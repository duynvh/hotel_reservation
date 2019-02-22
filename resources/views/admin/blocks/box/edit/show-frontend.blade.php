<div class="x_panel">
    <div class="x_title">
        <h2>Hiển thị trang chủ</h2>
        <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <div class="form-group">
            <?php
            if ($showFrontend == 'show') {
                $inactive = '';
                $active = 'checked';
            } else {
                $inactive = 'checked';
                $active = '';
            }
            $hidden = ($showFrontend == 'hidden');
            $show = ($showFrontend == 'show');
            ?>
            <div class="radio">
                <label>{{ Form::radio('show_frontend','show', $show, ['class' => 'flat']) }} Hiển thị</label>
            </div>
            <div class="radio">
                <label>{{ Form::radio('show_frontend','hidden', $hidden, ['class' => 'flat']) }} Không hiển thị</label>
            </div>
        </div>
    </div>
</div>