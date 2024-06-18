<footer class="site-footer">
    <div class="container">
        <div class="footer-row">
            <div class="footer-col footer-link">
                <div class="footer-widget">
                    <div class="footer-logo">
                        <a href="{{ route('home') }}" tabindex="0">
                            <img src="{{ Storage::url(Utility::getsettings('app_logo')) ? Utility::getpath('logo/app-logo.png') : asset('assets/images/logo/app-logo.png') }}"
                                class="footer-light-logo">
                            <img src="{{ Utility::getsettings('app_dark_logo') ? Utility::getpath('logo/app-dark-logo.png') : asset('assets/images/logo/app-dark-logo.png') }}"
                                class="footer-dark-logo">
                        </a>
                    </div>
                    <p>{{ Utility::getsettings('footer_description')
                        ? Utility::getsettings('footer_description')
                        : 'A feature is a unique quality or characteristic that something has. Real-life examples: Elaborately colored tail feathers are peacocks most well-known feature.' }}
                    </p>
                </div>
            </div>
            @if (Utility::getsettings('footer_setting_enable') == 'on')
                @php
                    $footerMainMenus = App\Models\FooterSetting::where('parent_id', 0)->get();
                @endphp
                @if (!empty($footerMainMenus))
                    @foreach ($footerMainMenus as $footerMainMenu)
                        <div class="footer-col">
                            <div class="footer-widget">
                                <h3>{{ $footerMainMenu->menu }}</h3>
                                @php
                                    $sub_menus = App\Models\FooterSetting::where('parent_id', $footerMainMenu->id)->get();
                                @endphp
                                <ul>
                                    @foreach ($sub_menus as $sub_menu)
                                        @php
                                            $page = App\Models\PageSetting::find($sub_menu->page_id);
                                        @endphp
                                        <li>
                                            <a @if ($page->type == 'link') ?  href="{{ $page->page_url }}"  @else  href="{{ route('description.page', $sub_menu->slug) }}" @endif
                                                tabindex="0">{{ $page->title }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endforeach
                @endif
            @endif
        </div>
        <div class="footer-bottom">
            <div class="row align-items-center">
                <div class="col-12">
                    <p> {{ __('© 2023 Full Multi Tenancy Laravel Admin Saas') }} </p>
                </div>
            </div>
        </div>
    </div>
</footer>
