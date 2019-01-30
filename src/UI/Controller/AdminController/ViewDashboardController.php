<?php

namespace App\UI\Controller\AdminController;

use App\UI\Controller\AdminController\Interfaces\ViewDashboardControllerInterface;
use App\Domain\Repository\UserRepository;
use App\UI\Responder\Interfaces\TwigResponderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ViewDashboardController
 * @package App\Controller\AdminController
 *
 * @Route("/dashboard", name="dashboard", methods={"GET"})
 * @Security("has_role('ROLE_ADMIN')")
 */
final class ViewDashboardController implements ViewDashboardControllerInterface
{

    /**
     * @var UserRepository
     */
    private $repository;

    /**
     * ViewDashboardController constructor.
     * @inheritdoc
     */
    public function __construct(
        UserRepository $repository
    ) {

        $this->repository = $repository;
    }

    /**
     * @inheritdoc
     */
    public function __invoke(TwigResponderInterface $responder): Response
    {
        $users = $this->repository->findAll();

        return $responder('admin/dashboard.html.twig', [
            'users' => $users
        ]);
    }
}
