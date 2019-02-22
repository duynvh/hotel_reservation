<div class="x_panel">
    <div class="x_title">
        <h2>Tình trạng hàng</h2>
        <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <div class="form-group">
            <?php
            if ($check_item == 'active') {
                $inactive = '';
                $active = 'checked';
            } else {
                $inactive = 'checked';
                $active = '';
            }
            $hidden = ($check_item == 'inactive');
            $show = ($check_item == 'active');
            ?>
            <div class="radio">
                <label>{{ Form::radio('check_item','active', $show, ['class' => 'flat']) }} Còn hàng</label>
            </div>
            <div class="radio">
                <label>{{ Form::radio('check_item','inactive', $hidden, ['class' => 'flat']) }} Hết hàng</label>
            </div>
        </div>
    </div>
</div>