<div class="x_panel">
    <div class="x_title">
        <h2>Hàng mới</h2>
        <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <div class="form-group">
            <?php
            if ($new == 'active') {
                $inactive = '';
                $active = 'checked';
            } else {
                $inactive = 'checked';
                $active = '';
            }
            $hidden = ($new == 'inactive');
            $show = ($new == 'active');
            ?>
            <div class="radio">
                <label>{{ Form::radio('new','active', $show, ['class' => 'flat']) }} Hoạt động</label>
            </div>
            <div class="radio">
                <label>{{ Form::radio('new','inactive', $hidden, ['class' => 'flat']) }} Không hoạt động</label>
            </div>
        </div>
    </div>
</div>