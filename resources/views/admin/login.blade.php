<html lang="en">
    <head>
        @include('admin.skins.meta')
        @include('admin.skins.styleSheet')
    </head>

    <body class="login">
    <div>
        <a class="hiddenanchor" id="signup"></a>
        <a class="hiddenanchor" id="signin"></a>

        <div class="login_wrapper">
            <div class="animate form login_form">
                <section class="login_content">
                        {!! Form::open(array(
                            'id' => 'submit_form',
                            'class' => 'form-horizontal ',
                            'method' => 'POST',
                            'url'=> route('admin.login.post')
                        )) !!}
                        <h1>Đăng nhập</h1>
                        @include('admin.blocks.notify.notify_error')
                        <div>
                            <input type="email" class="form-control" placeholder="Email" name="email"/>
                        </div>
                        <div>
                            <input type="password" class="form-control" placeholder="Password" name="password"/>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-default submit">Đăng nhập</button>
                            <a class="reset_pass" href="#">Quên mật khẩu?</a>
                        </div>

                        <div class="clearfix"></div>

                        <div class="separator">

                            <div class="clearfix"></div>
                            <br />

                            <div>
                                <h1><i class="fa fa-paw"></i> Gentelella Alela!</h1>
                                <p>©2016 All Rights Reserved. Gentelella Alela! is a Bootstrap 3 template. Privacy and Terms</p>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </section>
            </div>
        </div>
    </div>
    </body>
</html>
