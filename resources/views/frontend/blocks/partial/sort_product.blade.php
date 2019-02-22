<form class="form-inline" action="">
    <div class="form-group selectpicker-wrapper">
        <select class="selectpicker input-price" data-live-search="true"
                data-width="100%"
                data-toggle="tooltip" title="Select" id="sort-list" onchange="redirectUrl(this)">
            <option value="default">Phổ biến</option>
            @if(isset($_GET['sortP']))
                <option <?php echo $_GET['sortP'] == "nameasc" ? "selected" : "" ?> value="{{ 'sortP=nameasc' }}">Tên
                    A-Z
                </option>
                <option <?php echo $_GET['sortP'] == "namedesc" ? "selected" : "" ?> value="{{ 'sortP=namedesc' }}">Tên
                    Z-A
                </option>
                <option <?php echo $_GET['sortP'] == "priceasc" ? "selected" : "" ?> value="{{ 'sortP=priceasc' }}">Giá
                    tăng dần
                </option>
                <option <?php echo $_GET['sortP'] == "pricedesc" ? "selected" : "" ?>value="{{ 'sortP=pricedesc' }}">Giá
                    giảm dần
                </option>
            @else
                <option value="{{ 'sortP=nameasc' }}">Tên A-Z</option>
                <option value="{{ 'sortP=namedesc' }}">Tên Z-A</option>
                <option value="{{ 'sortP=priceasc' }}">Giá tăng dần</option>
                <option value="{{ 'sortP=pricedesc' }}">Giá giảm dần</option>
            @endif
        </select>
    </div>
</form>