<?php

return [
    'userManagement' => [
        'title'          => 'User management',
        'title_singular' => 'User management',
    ],
    'permission' => [
        'title'          => 'Permissions',
        'title_singular' => 'Permission',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'title'             => 'Title',
            'title_helper'      => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => ' ',
        ],
    ],
    'role' => [
        'title'          => 'Roles',
        'title_singular' => 'Role',
        'fields'         => [
            'id'                 => 'ID',
            'id_helper'          => ' ',
            'title'              => 'Title',
            'title_helper'       => ' ',
            'permissions'        => 'Permissions',
            'permissions_helper' => ' ',
            'created_at'         => 'Created at',
            'created_at_helper'  => ' ',
            'updated_at'         => 'Updated at',
            'updated_at_helper'  => ' ',
            'deleted_at'         => 'Deleted at',
            'deleted_at_helper'  => ' ',
        ],
    ],
    'user' => [
        'title'          => 'Users',
        'title_singular' => 'User',
        'fields'         => [
            'id'                       => 'ID',
            'id_helper'                => ' ',
            'name'                     => 'Name',
            'name_helper'              => ' ',
            'email'                    => 'Email',
            'email_helper'             => ' ',
            'email_verified_at'        => 'Email verified at',
            'email_verified_at_helper' => ' ',
            'password'                 => 'Password',
            'password_helper'          => ' ',
            'roles'                    => 'Roles',
            'roles_helper'             => ' ',
            'remember_token'           => 'Remember Token',
            'remember_token_helper'    => ' ',
            'created_at'               => 'Created at',
            'created_at_helper'        => ' ',
            'updated_at'               => 'Updated at',
            'updated_at_helper'        => ' ',
            'deleted_at'               => 'Deleted at',
            'deleted_at_helper'        => ' ',
        ],
    ],
    'iuran' => [
        'title'          => 'Iuran',
        'title_singular' => 'Iuran',
    ],
    'misc' => [
        'title'          => 'Misc',
        'title_singular' => 'Misc',
    ],
    'bill' => [
        'title'          => 'Iuran',
        'title_singular' => 'Iuran',
        'fields'         => [
            'id'                 => 'ID',
            'id_helper'          => ' ',
            'name'               => 'Nama Iuran',
            'name_helper'        => ' ',
            'description'        => 'Deskripsi',
            'description_helper' => ' ',
            'price'              => 'Nominal',
            'price_helper'       => ' ',
            'created_at'         => 'Created at',
            'created_at_helper'  => ' ',
            'updated_at'         => 'Updated at',
            'updated_at_helper'  => ' ',
            'deleted_at'         => 'Deleted at',
            'deleted_at_helper'  => ' ',
        ],
    ],
    'monthlyBill' => [
        'title'          => 'Iuran Bulanan',
        'title_singular' => 'Iuran Bulanan',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'tahun'             => 'Tahun',
            'tahun_helper'      => ' ',
            'bulan'             => 'Bulan',
            'bulan_helper'      => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => ' ',
        ],
    ],
    'userToMonthlyBill' => [
        'title'          => 'User to Monthly Bill',
        'title_singular' => 'User to Monthly Bill',
        'fields'         => [
            'id'                  => 'ID',
            'id_helper'           => ' ',
            'user'                => 'User',
            'user_helper'         => ' ',
            'created_at'          => 'Created at',
            'created_at_helper'   => ' ',
            'updated_at'          => 'Updated at',
            'updated_at_helper'   => ' ',
            'deleted_at'          => 'Deleted at',
            'deleted_at_helper'   => ' ',
            'monthly_bill'        => 'Monthly Bill',
            'monthly_bill_helper' => ' ',
        ],
    ],
    'monthlyBillToBill' => [
        'title'          => 'Monthly Bill To Bill',
        'title_singular' => 'Monthly Bill To Bill',
        'fields'         => [
            'id'                  => 'ID',
            'id_helper'           => ' ',
            'bill'                => 'Bill',
            'bill_helper'         => ' ',
            'created_at'          => 'Created at',
            'created_at_helper'   => ' ',
            'updated_at'          => 'Updated at',
            'updated_at_helper'   => ' ',
            'deleted_at'          => 'Deleted at',
            'deleted_at_helper'   => ' ',
            'monthly_bill'        => 'Monthly Bill',
            'monthly_bill_helper' => ' ',
        ],
    ],
    'pengumuman' => [
        'title'          => 'Pengumuman',
        'title_singular' => 'Pengumuman',
    ],
    'announcement' => [
        'title'          => 'Pengumuman',
        'title_singular' => 'Pengumuman',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'tittle'            => 'Judul',
            'tittle_helper'     => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => ' ',
            'content'           => 'Konten',
            'content_helper'    => ' ',
            'attachment'        => 'Lampiran',
            'attachment_helper' => ' ',
        ],
    ],
    'scope' => [
        'title'          => 'Scope dan Tempat',
        'title_singular' => 'Scope dan Tempat',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'name'              => 'Nama Tempat',
            'name_helper'       => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => ' ',
        ],
    ],
];