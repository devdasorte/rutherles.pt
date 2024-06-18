<div class="container-fluid rodape">
    <div class="row justify-content-center align-items-center" style="padding:15px">
        <div class="col-md-12 col-12">
            <ul class="list-unstyled d-flex flex-wrap justify-content-center social" style="margin-bottom:0px;">
                @if ($_settings->info('whatsapp_footer') != '')
                    <li class="spacing-icon">

                        <a class="whatsapp1" target="_blank"
                            href="
                                        {{ $_settings->info('whatsapp_footer') }}"
                            title="WhatsApp">

                            <i style="font-size:28px" class="bi bi-whatsapp"></i>
                        </a>

                    </li>
                @endif
                @if ($_settings->info('instagram_footer'))
                    <li class="spacing-icon">

                        <a class="instagram1" target="_blank"
                            href="
                                        {{ $_settings->info('instagram_footer') }} 
                                     "
                            title="Instagram">

                            <i style="font-size:28px" class="bi bi-instagram"></i>


                        </a>

                    </li>
                @endif

                @if ($_settings->info('facebook_footer') != '')
                    <li class="spacing-icon">

                        <a class="facebook1" target="_blank"
                            href=" {{ $_settings->info('facebook_footer') }} ]
                                    "
                            title="Facebook">
                            <i style="font-size:28px" class="bi bi-facebook"></i>


                        </a>

                    </li>
                @endif
                @if ($_settings->info('twitter_footer'))
                    <li class="spacing-icon">

                        <a class="twitter1" target="_blank" href="{{ $_settings->info('twitter_footer') }}"
                            title="Twitter">

                            <i style="font-size:28px" class="bi bi-twitter"></i>


                        </a>

                    </li>
                @endif


                @if ($_settings->info('youtube_footer'))
                    <li class="spacing-icon">
                        <a class="youtube1" target="_blank" href="{{ $_settings->info('youtube_footer') }}"
                            title="Youtube">
                            <i style="font-size:28px" class="bi bi-play-btn-fill"></i>

                        </a>

                    </li>
                @endif
            </ul>
        </div>
        <div class="col-md-12 col-12 font-xs">
            <hr>
            @if ($_settings->info('text_footer'))
                {{ blockHTML($_settings->info('text_footer')) }}
            @else
                <span style="color:var(--incrivel-primariaLink);">© Copyright {{ date('Y') }}-
                    {{ $_settings->info('name') }}.
                    Todos os direitos reservados.</span><br>
            @endif
            <div class="row mt-2" style="color:var(--incrivel-primariaLink);">
                <div class="col-12 font-xs">Desenvolvido por <a href="https://sorte.live" target="_blank"
                        class=" font-xs " rel="noreferrer" style="color:#fff">
                        {{ $_settings->info('name') }}
                    </a></div>
            </div>
        </div>









    </div>
</div>
