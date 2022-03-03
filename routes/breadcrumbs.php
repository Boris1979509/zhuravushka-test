<?php

use App\Repositories\PageRepository as Page;
use App\Repositories\BlogCategoryRepository as BlogCategory;
use App\Repositories\ProductRepository as Product;
use App\Repositories\ProductCategoryRepository as CategoryProduct;
use App\Repositories\BlogPostRepository as Post;
use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator as Generator;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use App\Models\User;

// Home
Breadcrumbs::for('home', static function (Generator $trail) {
    $trail->push('Главная', route('home'));
});
// 404
Breadcrumbs::for('errors.404', function ($trail) {
    $trail->parent('home');
    $trail->push(__('Page Not Found'));
});
// Page Service
Breadcrumbs::for('page.service', static function (Generator $trail) {
    $trail->parent('home');
    $trail->push('Услуги', route('page.service'));
});
// Page Blog
Breadcrumbs::for('blog', static function (Generator $trail) {
    $trail->parent('home');
    $trail->push(__('Sovety'), route('blog'));
});
// Category Blog
Breadcrumbs::for('blog.category', static function (Generator $trail, $categorySlug) {
    $trail->parent('blog');
    $category = (new BlogCategory)->getCategoryBySlug($categorySlug);
    $trail->push($category->title, route('blog.category', $category->slug));
});
// Blog Post
Breadcrumbs::for('blog.post', static function (Generator $trail, $postSlug) {
    $trail->parent('blog');
    $post = (new Post)->getPostBySlug($postSlug);
    $trail->push($post->title, route('blog.category', $post->slug));
});
// Any Page
Breadcrumbs::for('page', static function (Generator $trail, $pageSlug) {
    $trail->parent('home');
    $page = (new Page)->getFirstPageBySlug($pageSlug);
    $trail->push($page->title, route('page', $page->slug));
});
// User Cart
Breadcrumbs::for('cart', static function (Generator $trail) {
    $trail->parent('home');
    $trail->push(__('ProductsCart'), route('cart'));
});
// Order
Breadcrumbs::for('order.place', static function (Generator $trail) {
    $trail->parent('cart');
    $trail->push(__('Order Place'), route('order.place'));
});
Breadcrumbs::for('order.confirm', static function (Generator $trail) {
    $trail->parent('home');
    $trail->push(__('OrderInfo'), route('order.confirm'));
});
Breadcrumbs::for('order.confirm.payment', static function (Generator $trail) {
    $trail->parent('home');
    $trail->push(__('OrderInfo'), route('order.confirm.payment'));
});
Breadcrumbs::for('order.confirmNoPaid', static function (Generator $trail) {
    $trail->parent('home');
    $trail->push(__('OrderInfo'), route('order.confirmNoPaid'));
});
// Catalog main
Breadcrumbs::for('catalog', static function (Generator $trail) {
    $trail->parent('home');
    $trail->push('Каталог', route('catalog'));
});
// Product category
Breadcrumbs::for('category', static function (Generator $trail, $categoryProductSlug) {
    $category = (new CategoryProduct)->getBySlug($categoryProductSlug);
    if ($parent = $category->parent) {
        $trail->parent('category', $parent->slug);
    } else {
        $trail->parent('catalog');
    }
    $trail->push($category->title, route('category', $category->slug));
});
// Product
Breadcrumbs::for('product', static function (Generator $trail, $slug) {
    $product = (new Product)->getBySlug($slug);
    if ($category = $product->category) {
        $trail->parent('category', $category->slug);
    }
    $trail->push($product->title, route('product', $product->title));
});
// Favorite
Breadcrumbs::for('favorite', static function (Generator $trail) {
    $trail->parent('home');
    $trail->push(__('Favorite'), route('favorite'));
});
// Compare
Breadcrumbs::for('compare', static function (Generator $trail) {
    $trail->parent('home');
    $trail->push(__('Compare'), route('compare'));
});
// Login
Breadcrumbs::for('login', static function (Generator $trail) {
    $trail->parent('home');
    $trail->push(__('Login'), route('login'));
});
// Register
Breadcrumbs::for('register', static function (Generator $trail) {
    $trail->parent('home');
    $trail->push(__('Registration'), route('register'));
});
// Request Password
Breadcrumbs::for('password.request', static function (Generator $trail) {
    $trail->parent('home');
    $trail->push(__('Request Password'), route('password.request'));
});
// Reset password
Breadcrumbs::for('password.reset', function (Generator $trail, $token) {
    $trail->parent('home');
    $trail->push(__('Reset Password'), route('password.reset', $token));
});

// Cabinet
Breadcrumbs::register('cabinet.home', static function (Generator $crumbs) {
    $crumbs->push(__('Cabinet'), route('cabinet.home'));
});

/* Feedback */
Breadcrumbs::register('cabinet.feedback', static function (Generator $crumbs) {
    $crumbs->parent('cabinet.home');
    $crumbs->push(__('CabinetFeedBack'), route('cabinet.feedback'));
});
/* Comment */
Breadcrumbs::register('cabinet.comment', static function (Generator $crumbs) {
    $crumbs->parent('cabinet.home');
    $crumbs->push(__('CabinetComment'), route('cabinet.comment'));
});
/* Order */
Breadcrumbs::register('cabinet.order', static function (Generator $crumbs) {
    $crumbs->parent('cabinet.home');
    $crumbs->push(__('CabinetOrder'), route('cabinet.order'));
});
// Profile setting
Breadcrumbs::register('cabinet.profile.home', static function (Generator $crumbs) {
    $crumbs->parent('cabinet.home');
    $crumbs->push(__('ProfileSetting'), route('cabinet.profile.home'));
});
// Change password
Breadcrumbs::register('cabinet.change.password.index', static function (Generator $crumbs) {
    $crumbs->parent('cabinet.profile.edit');
    $crumbs->push(__('CabinetProfileChangePassword'), route('cabinet.change.password.index'));
});

Breadcrumbs::register('cabinet.profile.edit', static function (Generator $crumbs) {
    $crumbs->parent('cabinet.profile.home');
    $crumbs->push(__('CabinetProfileEdit'), route('cabinet.profile.edit'));
});
// Admin
Breadcrumbs::register('admin.home', static function (Generator $crumbs) {
    $crumbs->push(__('Dashboard'), route('admin.home'));
});
// Users
Breadcrumbs::register('admin.users.index', static function (Generator $crumbs) {
    $crumbs->parent('admin.home');
    $crumbs->push(__('Users'), route('admin.users.index'));
});

Breadcrumbs::register('admin.users.create', static function (Generator $crumbs) {
    $crumbs->parent('admin.users.index');
    $crumbs->push(__('Create'), route('admin.users.create'));
});

Breadcrumbs::register('admin.users.show', static function (Generator $crumbs, User $user) {
    $crumbs->parent('admin.users.index');
    $crumbs->push($user->name, route('admin.users.show', $user));
});

Breadcrumbs::register('admin.users.edit', static function (Generator $crumbs, User $user) {
    $crumbs->parent('admin.users.show', $user);
    $crumbs->push(__('Edit'), route('admin.users.edit', $user));
});
/* Search */
Breadcrumbs::register('search', static function (Generator $crumbs) {
    $crumbs->parent('home');
    $crumbs->push(__('Search'), route('search'));
});

// Admin Blog Posts
Breadcrumbs::for('admin.blog.posts.index', static function (Generator $crumbs) {
    $crumbs->parent('admin.home');
    $crumbs->push(__('Posts'), route('admin.blog.posts.index'));
});
Breadcrumbs::for('admin.blog.posts.edit', static function (Generator $crumbs, $id) {
    $crumbs->parent('admin.blog.posts.index');
    $crumbs->push(__('Edit'), route('admin.blog.posts.edit', $id));
});
Breadcrumbs::for('admin.blog.posts.create', static function (Generator $crumbs) {
    $crumbs->parent('admin.blog.posts.index');
    $crumbs->push(__('Create'), route('admin.blog.posts.create'));
});
// Admin Blog Category
Breadcrumbs::for('admin.blog.categories.index', static function (Generator $crumbs) {
    $crumbs->parent('admin.blog.posts.index');
    $crumbs->push(__('Categories'), route('admin.blog.categories.index'));
});
Breadcrumbs::for('admin.blog.categories.edit', static function (Generator $crumbs, $id) {
    $crumbs->parent('admin.blog.categories.index');
    $crumbs->push(__('Edit'), route('admin.blog.categories.edit', $id));
});
Breadcrumbs::for('admin.blog.categories.create', static function (Generator $crumbs) {
    $crumbs->parent('admin.blog.categories.index');
    $crumbs->push(__('Create'), route('admin.blog.categories.create'));
});
// Admin Orders
Breadcrumbs::for('admin.orders.index', static function (Generator $crumbs) {
    $crumbs->parent('admin.home');
    $crumbs->push(__('AdminOrders'), route('admin.orders.index'));
});
