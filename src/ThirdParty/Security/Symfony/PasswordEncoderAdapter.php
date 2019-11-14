<?php

namespace App\ThirdParty\Security\Symfony;

use App\Domain\Entity\User;
use Faker\Provider\Base as BaseProvider;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PasswordEncoderAdapter extends BaseProvider
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder) {
        $this->encoder = $encoder;
    }

    public function encodePassword(User $user, string $plainPassword)
    {
        return $this->encoder->encodePassword(
            new UserAdapter($user),
            $plainPassword
        );
    }
}
