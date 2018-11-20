import re

class TableStructList(list):
    def __init__(self, struct_body):
        super().__init__([TableStruct(line) for line in struct_body])
        self.names = [struct.name for struct in self]

    def __contains__(self, strcut):
        if not isinstance(strcut, TableStruct):
            return False
        if strcut.name not in self.names:
            return False
        return True

    @property
    def num(self):
        return len(self)

    def append(self, strcut):
        assert isinstance(strcut, TableStruct)
        super().append(strcut)
        self.names.append(strcut.name)


class TableStruct(object):
    def __init__(self, struct):
        info = struct.strip(' ,').split(' ')
        self.name = info[0].strip('`')
        self.type = info[1]
        self.more = ' '.join(info[2:])

    def __repr__(self):
        return '<TableStruct name=%s, type=%s, more=%s>' % (self.name, self.type, self.more)

    def get_struct_string(self):
        return '  `%s` %s %s,' % (self.name, self.type, self.more)


class TableData(object):
    def __init__(self, data):
        self.data = re.findall(r"'(.*?)'", data)

    def __repr__(self):
        return '<TableData data=[%s], num=%d>' % (', '.join(self.data), self.num)

    @property
    def num(self):
        return len(self.data)

    def add_data(self, target_num):
        add_num = max(target_num - self.num, 0)
        self.data += ['' for _ in range(add_num)]

    def get_data_string(self, name):
        data = ["'%s'" % data_item for data_item in self.data]
        return "INSERT INTO `%s` VALUES (%s);" % (name, ', '.join(data))


class Table(object):
    def __init__(self, struct, data):
        self._struct = struct.splitlines()
        self._data = data.splitlines()
        self.name = self.get_table_name(struct)
        self.struct_info = [line for line in self._struct if not line.startswith('  `')]
        struct_body = [line for line in self._struct if line.startswith('  `')]
        self.struct = TableStructList(struct_body)
        self.data_info = self._data[:3]
        self.data = [TableData(line) for line in self._data[3:]]

    def __repr__(self):
        return '<Table name=%s>' % self.name

    def get_table_name(self, struct):
        pattern = r'Table structure for (.*?)\n'
        try:
            return re.findall(pattern, struct)[0]
        except IndexError:
            return ''

    def merge(self, table):
        assert isinstance(table, Table)

        for struct_item in table.struct:
            if struct_item not in self.struct:
                self.struct.append(struct_item)
                print('表%s添加字段%s' % (self.name, struct_item.name))

        for data_item in self.data:
            data_item.add_data(self.struct.num)

    def struct_display(self):
        display = self.struct_info[:5]
        display += [struct.get_struct_string() for struct in self.struct]
        display += self.struct_info[5:]
        return display

    def data_display(self):
        display = self.data_info
        display += [data.get_data_string(self.name) for data in self.data]
        return display

    def display(self):
        return '\n\n'.join(['\n'.join(self.struct_display()), '\n'.join(self.data_display())])


def get_sql_tables(db):
    with open(db, 'r', encoding='utf-8') as file:
        split_content = file.read().split('\n\n')

    structs = [content for content in split_content if 'Table structure for' in content]
    datas = [content for content in split_content if 'Records of' in content]
    tables = [Table(struct, data) for struct, data in zip(structs, datas)]
    return {table.name:table for table in tables}


def main():
    old_db = 'db/old.sql'
    new_db = 'db/new.sql'
    outuput_db = 'db/db.sql'
    old_tables = get_sql_tables(old_db)
    new_tables = get_sql_tables(new_db)

    for name, table in old_tables.items():
        tran_name = name.replace('dsc', 'ecs')
        if tran_name in new_tables:
            print('合并%s与%s' % (name, tran_name))
            new_table = new_tables[tran_name]
            new_table.merge(table)
        else:
            print('%s不存在, 添加' % tran_name)
            table.name = tran_name
            new_tables[tran_name] = table

    with open(outuput_db, 'w+', encoding='utf-8') as file:
        for _, table in new_tables.items():
            file.write(table.display())
            file.write('\n\n')

if __name__ == '__main__':
    main()
