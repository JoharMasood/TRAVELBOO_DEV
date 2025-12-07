<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use PhpParser\Node\Expr\Assign;

class AssignRoleToUser extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::find(1);
        $user->assignRole('Admin');
        $users = User::where('id', '!=', 1)->get();

        foreach ($users as $user) {

            if ($user->accountnumber) {
                $user->assignRole('Company');
            } else {
                $user->assignRole('User');
            }
        }
    }
}
