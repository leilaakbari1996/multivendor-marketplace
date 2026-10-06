<ul class="navbar-nav justify-content-end menu-list list-unstyled d-flex gap-md-3 mb-0">

    @foreach ($headerMenus as $menu)

        @if ($menu->children->isNotEmpty())

            <li class="nav-item dropdown">

                <a
                    href="{{ $menu->url ?: '#' }}"
                    class="nav-link dropdown-toggle"
                    role="button"
                    id="menu-{{ $menu->id }}"
                    data-bs-toggle="dropdown"
                    aria-expanded="false"
                >
                    {{ $menu->title }}
                </a>

                <ul
                    class="dropdown-menu"
                    aria-labelledby="menu-{{ $menu->id }}"
                >

                    @foreach ($menu->children as $child)

                        <li>
                            <a
                                href="{{ $child->url ?: '#' }}"
                                class="dropdown-item"
                            >
                                {{ $child->title }}
                            </a>
                        </li>

                    @endforeach

                </ul>

            </li>

        @else

            <li class="nav-item">

                <a
                    href="{{ $menu->url ?: '#' }}"
                    class="nav-link"
                >
                    {{ $menu->title }}
                </a>

            </li>

        @endif

    @endforeach

</ul>
