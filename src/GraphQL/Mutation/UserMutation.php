<?php
namespace App\GraphQL\Mutation;

use App\GraphQL\Input\RegisterInput;
use App\GraphQL\Input\UserInput;
use App\Service\AuthenticatorService;
use App\Service\UserService;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Overblog\GraphQLBundle\Definition\Argument;
use Symfony\Component\DependencyInjection\ContainerInterface;

class UserMutation extends AuthMutation
{
    private $jwtManager;

    private $authenticator;

    private $authenticatorService;

    public function __construct(
        ContainerInterface $container,
        AuthenticatorService $authenticatorService,
        JWTTokenManagerInterface $JWTManager,
        AuthenticatorService $authenticator,
        UserService $userService
    ) {
        $this->authenticatorService = $authenticatorService;
        $this->jwtManager = $JWTManager;
        $this->authenticator = $authenticator;
        $this->userService = $userService;
        parent::__construct($container, $authenticatorService);
    }

    public function auth(Argument $args)
    {
        $input = new UserInput($args);

        if($user = $this->authenticator->auth($input->email, $input->password)) {
            $user->setHash($this->jwtManager->create($user));
            return $user;
        }
    }

    public function register(Argument $args)
    {
        $input = new RegisterInput($args);

        $this->userService->create($input);

        if($user = $this->authenticator->auth($input->email, $input->password)) {
            $user->setHash($this->jwtManager->create($user));
            return $user;
        }

        return $user;
    }
}