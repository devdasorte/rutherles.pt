@extends('vendor.installer.layouts.master')

@section('template_title')
    {{ trans('installer_messages.environment.wizard.templateTitle') }}
@endsection

@section('title')
    <i class="fa fa-magic fa-fw" aria-hidden="true"></i>
    {!! trans('installer_messages.environment.wizard.title') !!}
@endsection

@section('container')
    <div class="tabs tabs-full">

        <form method="post" action="{{ route('LaravelInstaller::environmentSaveWizard') }}">
            <label for="tab1" class="tab-label">
                <i class="fa fa-cog fa-2x fa-fw" aria-hidden="true"></i>
                <br />
                {{ trans('installer_messages.environment.wizard.tabs.environment') }}
            </label>
            <div id="tab1content">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group {{ $errors->has('app_name') ? ' has-error ' : '' }}">
                    <label for="app_name">
                        {{ trans('installer_messages.environment.wizard.form.app_name_label') }}
                    </label>
                    <input type="text" name="app_name" id="app_name" value=""
                        placeholder="{{ trans('installer_messages.environment.wizard.form.app_name_placeholder') }}" />
                    @if ($errors->has('app_name'))
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('app_name') }}
                        </span>
                    @endif
                </div>

                <input type="hidden" name="environment" value="production" />
                <input type="hidden" name="app_debug" value="false" />
                <input type="hidden" name="app_log_level" value="debug" />

                @php
                    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
                    $url = $protocol . '://' . $_SERVER['HTTP_HOST'];
                @endphp
                <div class="form-group {{ $errors->has('app_url') ? ' has-error ' : '' }}">
                    <label for="app_url">
                        {{ trans('installer_messages.environment.wizard.form.app_url_label') }}
                    </label>
                    <input type="url" name="app_url" id="app_url" value="{{ $url }}"
                        placeholder="{{ trans('installer_messages.environment.wizard.form.app_url_placeholder') }}" />
                    @if ($errors->has('app_url'))
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('app_url') }}
                        </span>
                    @endif
                </div>
                <div class="form-group {{ $errors->has('domain') ? ' has-error ' : '' }}">
                    <label for="domain">
                        {{ __('Domain Name') }}
                    </label>
                    <input type="text" name="domain" id="domain" value="{{ $_SERVER['HTTP_HOST'] }}"
                        placeholder="{{ __('Domain Name') }}" />
                    @if ($errors->has('domain'))
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('domain') }}
                        </span>
                    @endif
                </div>
            </div>

            <div class="alert alert-info">
                <ul>
                    <li>{{ __('If you want to run your website in localhost then it is necessary to be a vhost, because of
                        tenancy-based software it is necessary to create a vhost.')}} </li>
                    <li class="text-danger"> {{ __('If you give incorrect website host,then 404 error will be shown throughout the
                        whole
                        website') }} </li>
                    <li> {{ __('if your website URL is') }} <span class="text-danger">https://example.com/</span> {{ __(',then host will be') }}
                        <span class="text-danger">example.com</span>
                    </li>
                    <li> {{ __('if your website URL is') }} <span class="text-danger">https://subdomain.example.com/</span> {{ __(',then host
                        will
                        be') }} <span class="text-danger"> {{ __('subdomain.example.com') }} </span>
                    </li>
                </ul>
            </div>

            <label for="tab2" class="tab-label">
                <i class="fa fa-database fa-2x fa-fw" aria-hidden="true"></i>
                <br />
                {{ trans('installer_messages.environment.wizard.tabs.database') }}
            </label>
            <div id="tab2content">

                <input type="hidden" name="database_connection" value="mysql" />
                <div class="form-group {{ $errors->has('database_connection') ? ' has-error ' : '' }}">
                    <label for="database_connection">
                        {{ trans('installer_messages.environment.wizard.form.db_connection_label') }}
                    </label>
                    <b>{{ trans('installer_messages.environment.wizard.form.db_connection_label_mysql') }}</b>
                    <br><br>

                </div>

                <div class="form-group {{ $errors->has('database_hostname') ? ' has-error ' : '' }}">
                    <label for="database_hostname">
                        {{ trans('installer_messages.environment.wizard.form.db_host_label') }}
                    </label>
                    <input type="text" name="database_hostname" id="database_hostname" value="127.0.0.1"
                        placeholder="{{ trans('installer_messages.environment.wizard.form.db_host_placeholder') }}" />
                    @if ($errors->has('database_hostname'))
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('database_hostname') }}
                        </span>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('database_port') ? ' has-error ' : '' }}">
                    <label for="database_port">
                        {{ trans('installer_messages.environment.wizard.form.db_port_label') }}
                    </label>
                    <input type="number" name="database_port" id="database_port" value="3306"
                        placeholder="{{ trans('installer_messages.environment.wizard.form.db_port_placeholder') }}" />
                    @if ($errors->has('database_port'))
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('database_port') }}
                        </span>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('database_name') ? ' has-error ' : '' }}">
                    <label for="database_name">
                        {{ trans('installer_messages.environment.wizard.form.db_name_label') }}
                    </label>
                    <input type="text" name="database_name" id="database_name" value=""
                        placeholder="{{ trans('installer_messages.environment.wizard.form.db_name_placeholder') }}" />
                    @if ($errors->has('database_name'))
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('database_name') }}
                        </span>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('database_username') ? ' has-error ' : '' }}">
                    <label for="database_username">
                        {{ trans('installer_messages.environment.wizard.form.db_username_label') }}
                    </label>
                    <input type="text" name="database_username" id="database_username" value=""
                        placeholder="{{ trans('installer_messages.environment.wizard.form.db_username_placeholder') }}" />
                    @if ($errors->has('database_username'))
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('database_username') }}
                        </span>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('database_password') ? ' has-error ' : '' }}">
                    <label for="database_password">
                        {{ trans('installer_messages.environment.wizard.form.db_password_label') }}
                    </label>
                    <input type="password" name="database_password" id="database_password" value=""
                        placeholder="{{ trans('installer_messages.environment.wizard.form.db_password_placeholder') }}" />
                    @if ($errors->has('database_password'))
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('database_password') }}
                        </span>
                    @endif
                </div>


            </div>
            <div id="tab3content">

                <input type="hidden" name="broadcast_driver" value="log" />

                <input type="hidden" name="cache_driver" value="file" />

                <input type="hidden" name="session_driver" value="file" />

                <input type="hidden" name="queue_driver" value="sync" />

                <input type="hidden" name="redis_hostname" value="127.0.0.1" />

                <input type="hidden" name="redis_password" value="null" />

                <input type="hidden" name="redis_port" value="6379" />

                <input type="hidden" name="mail_driver" value="smtp" />

                <input type="hidden" name="mail_host" value="smtp.mailtrap.io" />

                <input type="hidden" name="mail_port" value="2525" />

                <input type="hidden" name="mail_username" value="null" />

                <input type="hidden" name="mail_password" value="null" />

                <input type="hidden" name="mail_encryption" value="null" />

                <input type="hidden" name="pusher_app_id" value="" />

                <input type="hidden" name="pusher_app_key" value="" />

                <input type="hidden" name="pusher_app_secret" value="" />


                <div class="buttons">
                    <button class="button" type="submit">
                        {{ trans('installer_messages.environment.wizard.form.buttons.install') }}
                        <i class="fa fa-angle-right fa-fw" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
        </form>

    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        function checkEnvironment(val) {
            var element = document.getElementById('environment_text_input');
            if (val == 'other') {
                element.style.display = 'block';
            } else {
                element.style.display = 'none';
            }
        }

        function showDatabaseSettings() {
            document.getElementById('tab2').checked = true;
        }

        function showApplicationSettings() {
            document.getElementById('tab3').checked = true;
        }
    </script>
@endsection
