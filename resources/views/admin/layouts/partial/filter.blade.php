<?php if(!isset($hidden) || !$hidden) : ?>
    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                {!! Form::open(array(
                    'id' => 'submit_form',
                    'class' => 'form-horizontal ',
                    'method' => 'get',
                    'url' => $action
                )) !!}
                    <div class="x_title">
                        <h2>Tìm kiếm & Lọc</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li>
                                <a href="{{$action}}" class="refresh-link" data-toggle="tooltip" data-placement="bottom" data-original-title="Refresh">
                                    <i class="fa fa-refresh"></i>
                                </a>
                            </li>
                            <li>
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up" data-toggle="tooltip" data-placement="bottom" data-original-title="Show/Hide"></i>
                                </a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>

                    <div class="x_content">
                        <div class="col-md-5 col-fix-mar-left">
                            <div class="input-group">
                                <input type="text" name="q" value="{{Request::query('q')}}" class="form-control" autocomplete="Off" placeholder="Nhập vào nội dung tìm kiếm ...">
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-primary btn-mar-search" width="30px" data-toggle="tooltip" data-placement="bottom" data-original-title="Tìm kiếm">
                                        <i class="fa fa-search"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger clear-search" width="30px" data-toggle="tooltip" data-placement="bottom" data-original-title="Xóa tìm kiếm">
                                        <i class="fa fa-arrow-circle-o-left"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                        @if(!empty($group))
                            <div class="col-md-2 pull-right col-fix-mar-right">
                                {!! Form::select('group_id',
                                   $group,
                                   Request::query('group_id'),
                                   array( 'class' => 'form-control' )
                               ) !!}
                            </div>
                        @endif

                        @if(!empty($categoriesSelectBox))
                            <div class="col-md-2 pull-right col-fix-mar-right">
                                {!! Form::select('category_id',
                                   $categoriesSelectBox,
                                   Request::query('category_id'),
                                   array( 'class' => 'form-control' )
                               ) !!}
                            </div>
                        @endif

                        @if(!empty($listCourseSlbox))
                            <div class="col-md-2 pull-right col-fix-mar-right">
                                {!! Form::select('course_id',
                                   $listCourseSlbox,
                                   Request::query('course_id'),
                                   array( 'class' => 'form-control' )
                               ) !!}
                            </div>
                        @endif

                        @if(!empty($status))
                        <div class="col-md-2 pull-right col-fix-mar-right">
                            {!! Form::select('status',
                               $status,
                               Request::query('status'),
                               array( 'class' => 'form-control' )
                           ) !!}
                        </div>
                        @endif
                        @if(!empty($confirm_action))
                        <div class="col-md-2 pull-right col-fix-mar-right">
                            {!! Form::select('confirm_action',
                               $confirm_action,
                               Request::query('confirm_action'),
                               array( 'class' => 'form-control' )
                           ) !!}
                        </div>
                        @endif

                        @if(!empty($categoryArticle))
                            <div class="col-md-2 pull-right col-fix-mar-right">
                                {!! Form::select('category_article_id',
                                   $categoryArticle,
                                   Request::query('category_article_id'),
                                   array( 'class' => 'form-control' )
                               ) !!}
                            </div>
                        @endif

                        @if(!empty($amountType))
                            <div class="col-md-2 pull-right col-fix-mar-right">
                                {!! Form::select('amount_type',
                                   $amountType,
                                   Request::query('amount_type'),
                                   array( 'class' => 'form-control' )
                               ) !!}
                            </div>
                        @endif

                        @if(!empty($type))
                            <div class="col-md-2 pull-right col-fix-mar-right">
                                {!! Form::select('type',
                                   $type,
                                   Request::query('type'),
                                   array( 'class' => 'form-control' )
                               ) !!}
                            </div>
                        @endif
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
<?php endif; ?>

@section('js_customer')
    <script type="text/javascript">
        $(document).ready(function(){

            // Button search click
            $('.clear-search').click(function(){
                $('input[name="q"]').val('');
                $('.btn-mar-search').click();
            });

            // Select box change
            $('select[name="status"], select[name="confirm_action"], select[name="type"], select[name="category_article_id"], select[name="group_id"], select[name="amount_type"]').change(function(){
                $('.btn-mar-search').click();
            });
        });
    </script>
@endsection
