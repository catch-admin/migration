# thinkphp6 数据库迁移工具

## 安装
```shell
composer require catchadmin/migration
```

## 如何使用

### 创建 migration
```shell
php think migrete:create Good
```
### 编写 migration
迁移类包含两个方法：`up` , `change` 和 `down` 。
- `up` 方法用于向数据库中添加新表、列或索引，
- `down` 方法用于撤销 `up` 方法执行的操作
- `change` 修改表结构

```php
use catchAdmin\migration\Migrator;
use catchAdmin\migration\builder\Scheme;
use catchAdmin\migration\builder\Table;

class Goods extends Migrator
{
    public function up()
    {
        Scheme::create('goods_test', function (Table $table) {
            $table->id();

            $table->string('name')->default('')->comment('昵称');

            $table->smallInteger('sort')->default(0)->comment('排序');

            $table->double('price');

            $table->year('year');

            $table->timestamps();

            $table->softDelete('delete_at');
        });
    }

    public function down()
    {
        Scheme::drop('goods_test');
    }
}
```
创建完成之后，执行
```shell
php think migrate
```
如果需要指定执行某个 `migrate`
```php
php think migrate -t migrate_name
```

## 查看迁移状态
```shell
php think migrate:status
```

## 回滚迁移
如果要回滚最后一次迁移操作，可以使用 `Artisan` 命令 `rollback`。该命令会回滚最后「一批」的迁移，这可能包含多个迁移文件：
```shell
php think migrate:rollback
```
回滚某个指定的迁移文件
```shell
php think migrate:rollback -t migrate_name
```
通过向 `rollback `命令加上 `step` 参数，可以回滚指定数量的迁移。例如，以下命令将回滚最后五个迁移：
```shell
php think migrate:rollback --step=5
```
如果你想回滚全部，可以将 `step` 设置个非常大的值

## 数据填充
### 创建填充
```shell
php think make:seed Seeder 
```

### 填充数据
```php
use catchAdmin\migration\Seeder;

class Good extends Seeder
{
    public function run()
    {
        // 这里填充数据
    }
}
```

### 执行填充
```shell
php think seed:run
```

如果需要指定填充，可以使用下面的命令
```shell
php think seed:run -t Good
```
