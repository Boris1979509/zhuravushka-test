<?php

namespace App\UseCases\Products;

use App\Models\Shop\Product;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Repositories\ProductRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class CompareService
{
    /**
     * @var UserRepository $userRepository
     */
    private $userRepository;
    /**
     * @var ProductRepository $productRepository
     */
    private $productRepository;

    /**
     * CompareService constructor.
     * @param UserRepository $userRepository
     * @param ProductRepository $productRepository
     */
    public function __construct(UserRepository $userRepository, ProductRepository $productRepository)
    {
        $this->userRepository = $userRepository;
        $this->productRepository = $productRepository;
    }

    /**
     * @param int $userId
     * @param int $productId
     */
    public function add($userId, $productId): void
    {
        if ($product = $this->getProduct($productId)) {
            if ($user = $this->getUser($userId)) {
                $user->addToCompares($product->id);
            } else {
                $this->notUserAuthCompare($product);
            }
        }
    }

    public function remove($userId, $productId): void
    {
        if ($product = $this->getProduct($productId)) {
            if ($user = $this->getUser($userId)) {
                $user->removeFromCompares($product->id);
            } else {
                $this->notUserAuthCompare($product);
            }
        }
    }

    /**
     * @param Product $product
     */
    private function notUserAuthCompare($product): void
    {
        $compares = session('compares', []);
        $index = array_search($product->id, $compares, true);

        if ($index !== false) {
            unset($compares[$index]);
        } else {
            $compares[] = $product->id;
        }
        if (!empty($compares)) {
            session(compact('compares'));
        } else {
            session()->forget('compares');
        }
    }

    /**
     * @param int $userId
     * @return User|null
     */
    private function getUser($userId): ?User
    {
        return $this->userRepository->find($userId);
    }

    /**
     * @param int $productId
     * @return Product
     */
    private function getProduct($productId): Product
    {
        return $this->productRepository->find($productId);
    }

    /**
     * @return bool|Collection
     */
    public function getUserCompareList()
    {
        if (Auth::check()) {
            return Auth::user()->compares;
        }
        $compares = session('compares');
        if (!is_null($compares) && $compares > 0) {
            return $this->productRepository->whereInProducts($compares);
        }
        return false;
    }

    /**
     * Compare count
     * @return int
     */
    public function count(): int
    {
        if ($this->getUserCompareList()) {
            return $this->getUserCompareList()->count();
        }
        return 0;
    }
}
