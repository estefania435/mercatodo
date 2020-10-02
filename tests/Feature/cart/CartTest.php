<?php

namespace Tests\Feature\cart;

use App\MercatodoModels\Category;
use App\MercatodoModels\Order;
use App\MercatodoModels\Product;
use App\MercatodoModels\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function aNotAuthenticatedUserCannotShowToCart()
    {
        $response = $this->get(route('cart.show'));

        $response->assertRedirect('login');
    }

    /** @test */
    public function AnuserCanAddProductToCart(): void
    {
        $this->withoutExceptionHandling();
        factory(Category::class)->create();
        $product=factory(Product::class)->create([
            'quantity' => 1,
        ]);
        $user = factory(User::class)->create();
        factory(Order::class)->create();

        $response = $this->actingAs($user)->get(
            route('cart.add', $user),
            [
                'product_id' => $product->product_id,
                'quantity' => 1,
            ]
        );

        $response->assertRedirect(route('cart.show'));
    }

    /*public function testAnuserCanRemoveitemToCart(): void
    {
        $this->withoutExceptionHandling();
        factory(Category::class)->create();
        $user = factory(User::class)->create([
            'email_verified_at' => now()
        ]);

        factory(Order::class)->create([
            'user_id' => $user->id
        ]);

        $product = factory(Product::class)->create([
            'quantity' => 10
        ]);

        $response = $this->actingAs($user)->get(route('cart.delete', $user),
            [
                'product_id' => $product->product_id,
                'quantity' => 1
            ]);

        $response->assertStatus(302);

    }*/
}
