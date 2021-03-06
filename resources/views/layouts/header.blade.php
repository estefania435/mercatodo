<header>
    <!---->
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/home') }}">
                    Mercatodo
                <!--{{ config('app.name', 'Mercatodo') }}-->
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        @can('haveaccess','role.index')
                            <li class="nav-item"><a href="{{route('role.index')}}" class="nav-link">Role</a></li>
                        @endcan
                        @can('haveaccess','user.index')
                            <li class="nav-item"><a href="{{route('user.index')}}" class="nav-link">User</a></li>
                        @endcan
                        @can('haveaccess','admin.product.index')
                            <li class="nav-item"><a href="{{route('admin.product.index')}}"
                                class="nav-link">Product</a></li>
                        @endcan
                        @can('haveaccess','admin.product.index')
                            <li class="nav-item"><a href="{{route('admin.category.index')}}"
                                class="nav-link">Category</a></li>
                        @endcan

                    </ul>



                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">


                        <li class="nav-item"><a href="{{route('pay.showAllOrders')}}" class="nav-link">

                                <i class="fas fa-file-invoice-dollar"></i>Payments</a></li>

                        <!-- Authentication Links -->
                        <li class="nav-item">

                            <?php
                            $suma = 0;
                            if (!empty($cart)) {
                                foreach ($cart->details as $item) {
                                    $suma += $item->quantity;
                                }
                            }
                            ?>

                            <a class="nav-link" href="{{route('cart.show')}}"><i class="fas fa-shopping-cart"></i>
                                <?php echo ($suma > 0) ? '(' . $suma . ')' : '' ?>

                            </a>

                        </li>
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link btn btn-outline-primary"
                                       href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                       document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                          style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</header>
<!---->
