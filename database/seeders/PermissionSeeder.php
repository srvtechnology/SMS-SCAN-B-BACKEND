<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $list = "List of ";
        $add = "Add ";
        $edit = "Edit ";
        $delete = "Delete ";
        $detail = "Detail ";

        $permissions = [
            ['name' => 'Dashboard'],
            ['name' => $list.'Section'],
            ['name' => $add.'Section'],
            ['name' => $edit.'Section'],
            ['name' => $delete.'Section'],

            ['name' => $list.'Subject'],
            ['name' => $add.'Subject'],
            ['name' => $edit.'Subject'],
            ['name' => $delete.'Subject'],

            ['name' => $list.'Class'],
            ['name' => $add.'Class'],
            ['name' => $edit.'Class'],
            ['name' => $detail.'Class'],
            ['name' => $delete.'Class'],

            ['name' => $list.'Designation'],
            ['name' => $add.'Designation'],
            ['name' => $edit.'Designation'],
            ['name' => $delete.'Designation'],

            ['name' => $list.'Staff'],
            ['name' => $add.'Staff'],
            ['name' => $edit.'Staff'],
            ['name' => $detail.'Staff'],
            ['name' => $delete.'Staff'],

            ['name' => $list.'Student'],
            ['name' => $add.'Student'],
            ['name' => $edit.'Student'],
            ['name' => $detail.'Student'],
            ['name' => $delete.'Student'],

            ['name' => $list.'Parent'],

            ['name' => $list.'Study Material'],
            ['name' => $add.'Study Material'],
            ['name' => $edit.'Study Material'],
            ['name' => $detail.'Study Material'],
            ['name' => $delete.'Study Material'],

            ['name' => $list.'Time Range'],
            ['name' => $add.'Time Range'],
            ['name' => $edit.'Time Range'],
            ['name' => $delete.'Time Range'],

            ['name' => $list.'Time Range Period'],
            ['name' => $add.'Time Range Period'],
            ['name' => $edit.'Time Range Period'],
            ['name' => $detail.'Time Range Period'],
            ['name' => $delete.'Time Range Period'],

            ['name' => $list.'Assign Period'],
            ['name' => $add.'Assign Period'],
            ['name' => $edit.'Assign Period'],
            ['name' => $detail.'Assign Period'],
            ['name' => $delete.'Assign Period'],

            ['name' => $list.'Push Notification'],
            ['name' => $add.'Push Notification'],
            ['name' => $edit.'Push Notification'],
            ['name' => 'Send push Notification'],
            ['name' => $delete.'Push Notification'],

            ['name' => $list.'Exam'],
            ['name' => $add.'Exam'],
            ['name' => $edit.'Exam'],
            ['name' => $detail.'Exam'],
            ['name' => $delete.'Exam'],

            ['name' => $list.'Syllabus'],
            ['name' => $add.'Syllabus'],
            ['name' => $edit.'Syllabus'],
            ['name' => $detail.'Syllabus'],
            ['name' => $delete.'Syllabus'],

            ['name' => $list.'Exam Time Sheet'],
            ['name' => $add.'Exam Time Sheet'],
            ['name' => $edit.'Exam Time Sheet'],
            ['name' => $detail.'Exam Time Sheet'],
            ['name' => $delete.'Exam Time Sheet'],

            ['name' => $list.'Result'],
            ['name' => 'Filter Result'],

            ['name' => $list.'Attendance'],
            ['name' => 'Filter Attendance'],

            ['name' => $list.'Roles'],
            ['name' => $add.'Roles'],
            ['name' => $edit.'Roles'],
            ['name' => $delete.'Roles'],

            ['name' => $list.'Admin Users'],
            ['name' => $add.'Admin Users'],
            ['name' => $edit.'Admin Users'],
            ['name' => $delete.'Admin Users'],
        ];

        foreach($permissions as $permission)
        {
            $count = Permission::where('name', $permission['name'])->count();
            if($count == 0)
            {
                $entry_permission = new Permission;
                $entry_permission->name = $permission['name'];
                $entry_permission->save();
            }
        }
    }
}
