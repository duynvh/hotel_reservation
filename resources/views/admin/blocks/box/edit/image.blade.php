<div class="x_panel">
    <div class="x_title">
        <h2>Hình ảnh</h2>
        <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <div class="form-group">
        <input type="file" id="image" class="form-control" onchange="previewSelectImage(this)"
        name="image">
        <img id="imagePreview" src="{{ asset('public/upload/images/' . $image) }}" alt="image preview"
                style="width: 100%"/>
        </div>
    </div>
</div>