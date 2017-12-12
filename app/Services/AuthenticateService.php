<?php

namespace App\Services;

use App\Repositories\Eloquent\AdminRepository;

class AuthenticateService
{

    /**
     * AdminRepository
     *
     * @var AdminRepository
     */
    protected $adminRepository;

    /**
     * Constructor.
     *
     * @param AdminRepository $adminRepository AdminRepository
     */
    public function __construct(AdminRepository $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    }

    /**
     * Retrieve admin user
     *
     * @param array $data Data for filter
     *
     * @return \App\Models\Admin
     */
    public function retrieveByCredentials(array $data)
    {
        $columns = [
            'id',
            'email',
            'password',
            'name',
            'created_at'
        ];
        $attributes = ['email' => $data['email']];
        $admin = $this->adminRepository->firstWhere($attributes, $columns);

        if (!empty($admin)) {
            if ($this->validateCredentials($admin, $data)) {
                return $admin;
            }
        }

        return null;
    }

    /**
     * Validate a user against the given credentials.
     *
     * @param \Illuminate\Contracts\Auth\Authenticatable $admin       Admin
     * @param array                                      $credentials Input data
     *
     * @return bool
     */
    public function validateCredentials($admin, array $credentials)
    {
        $plain = $credentials['password'];
        return app('hash')->check($plain, $admin->getAuthPassword());
    }
}
