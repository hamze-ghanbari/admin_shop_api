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
            'update-banner' => 'ویرایش بنر',
            'delete-banner' => 'حذف بنر',
            'read-discount' => 'دیدن کد تخفیف',
            'create-discount' => 'ایجاد کد تخفیف',
            'update-discount' => 'ویرایش کد تخفیف',
            'delete-discount' => 'حذف کد تخفیف',
            'read-post' => 'دیدن پست',
            'create-post' => 'ایجاد پست',
            'update-post' => 'ویرایش پست',
            'delete-post' => 'حذف پست',
            'read-product' => 'دیدن محصول',
            'create-product' => 'ایجاد محصول',
            'update-product' => 'ویرایش محصول',
            'delete-product' => 'حذف محصول',
            'read-ticket' => 'دیدن تیکت',
            'create-ticket' => 'ایجاد تیکت',
            'update-ticket' => 'ویرایش تیکت',
            'delete-ticket' => 'حذف تیکت',
            'read-user' => 'دیدن کاربر',
            'create-user' => 'ایجاد کاربر',
            'update-user' => 'ویرایش کاربر',
            'delete-user' => 'حذف کاربر',
            'read-role' => 'دیدن نقش',
            'create-role' => 'ایجاد نقش',
            'update-role' => 'ویرایش نقش',
            'delete-role' => 'حذف نقش',
            'read-category' => 'دیدن دسته بندی',
            'create-category' => 'ایجاد دسته بندی',
            'update-category' => 'ویرایش دسته بندی',
            'delete-category' => 'حذف دسته بندی',
            'read-brand' => 'دیدن برند',
            'create-brand' => 'ایجاد برند',
            'update-brand' => 'ویرایش برند',
            'delete-brand' => 'حذف برند',
            'read-mail' => 'دیدن ایمیل',
            'create-mail' => 'ایجاد ایمیل',
            'update-mail' => 'ویرایش ایمیل',
            'delete-mail' => 'حذف ایمیل',
            'read-mail-file' => 'دیدن فایل ایمیل',
            'create-mail-file' => 'ایجاد فایل ایمیل',
            'update-mail-file' => 'ویرایش فایل ایمیل',
            'delete-mail-file' => 'حذف فایل ایمیل',
            'read-delivery' => 'دیدن روش ارسال ',
            'create-delivery' => 'ایجاد روش  ارسال',
            'update-delivery' => 'ویرایش روش ارسال',
            'delete-delivery' => 'حذف روش ارسال',
            'read-meta-product' => 'دیدن ویژگی محصولات',
            'create-meta-product' => 'ایجاد ویژگی محصولات',
            'update-meta-product' => 'ویرایش ویژگی محصولات',
            'delete-meta-product' => 'حذف ویژگی محصولات',
            'read-color-product' => 'دیدن رنگ محصولات',
            'create-color-product' => 'ایجاد رنگ محصولات',
            'update-color-product' => 'ویرایش رنگ محصولات',
            'delete-color-product' => 'حذف رنگ محصولات',
            'read-gallery-product' => 'دیدن گالری محصولات',
            'create-gallery-product' => 'ایجاد گالری محصولات',
            'update-gallery-product' => 'ویرایش گالری محصولات',
            'delete-gallery-product' => 'حذف گالری محصولات',
            'read-attribute' => 'دیدن فرم دسته بندی ها',
            'create-attribute' => 'ایجاد فرم دسته بندی ها',
            'update-attribute' => 'ویرایش فرم دسته بندی ها',
            'delete-attribute' => 'حذف فرم دسته بندی ها',
        ];

        foreach ($permissions as $key => $value) {
            Permission::updateOrCreate(
                ['name' => $key],
                ['persian_name' => $value]
            );
        }

//        User::factory(10)->create();
        // $this->call("OthersTableSeeder");
    }

}
