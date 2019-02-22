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
            <div class="radio">
                <label>{{ Form::radio('new','active', true, ['class' => 'flat']) }} Hoạt động</label>
            </div>
            <div class="radio">
                <label>{{ Form::radio('new','inactive', false, ['class' => 'flat']) }} Không hoạt động</label>
            </div>
        </div>
    </div>
</div>