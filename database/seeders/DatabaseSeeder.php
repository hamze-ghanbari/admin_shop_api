<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Permission;
use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        Model::unguard();

        $permissions = [
            'read-banner' => 'دیدن بنر',
            'create-banner' => 'ایجاد بنر',
            'edit-banner' => 'ویرایش بنر',
            'delete-banner' => 'حذف بنر',
            'read-discount' => 'دیدن کد تخفیف',
            'create-discount' => 'ایجاد کد تخفیف',
            'edit-discount' => 'ویرایش کد تخفیف',
            'delete-discount' => 'حذف کد تخفیف',
            'read-post' => 'دیدن پست',
            'create-post' => 'ایجاد پست',
            'edit-post' => 'ویرایش پست',
            'delete-post' => 'حذف پست',
            'read-product' => 'دیدن محصول',
            'create-product' => 'ایجاد محصول',
            'edit-product' => 'ویرایش محصول',
            'delete-product' => 'حذف محصول',
            'read-ticket' => 'دیدن تیکت',
            'create-ticket' => 'ایجاد تیکت',
            'edit-ticket' => 'ویرایش تیکت',
            'delete-ticket' => 'حذف تیکت',
            'read-user' => 'دیدن کاربر',
            'create-user' => 'ایجاد کاربر',
            'edit-user' => 'ویرایش کاربر',
            'delete-user' => 'حذف کاربر',
            'read-role' => 'دیدن نقش',
            'create-role' => 'ایجاد نقش',
            'edit-role' => 'ویرایش نقش',
            'delete-role' => 'حذف نقش',
            'read-category' => 'دیدن دسته بندی',
            'create-category' => 'ایجاد دسته بندی',
            'edit-category' => 'ویرایش دسته بندی',
            'delete-category' => 'حذف دسته بندی',
            'read-brand' => 'دیدن برند',
            'create-brand' => 'ایجاد برند',
            'edit-brand' => 'ویرایش برند',
            'delete-brand' => 'حذف برند',
            'read-mail' => 'دیدن ایمیل',
            'create-mail' => 'ایجاد ا یمیل',
            'edit-mail' => 'ویرایش ایمیل',
            'delete-mail' => 'حذف ایمیل'
        ];

        foreach ($permissions as $key => $value) {
            Permission::updateOrCreate(
                ['name' => $key],
                ['persian_name' => $value]
            );
        }

        User::factory(10)->create();
        // $this->call("OthersTableSeeder");
    }

}
