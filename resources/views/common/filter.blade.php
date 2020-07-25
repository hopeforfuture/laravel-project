<div class="col-lg-12" id="filter_area" style="display:none;">
    <div class="panel panel-default">
        <div class="panel-body">
            <form action="{{ route('news.index') }}" method="GET" class="form-horizontal">
                
                <div class="form-group">
                    <label class="control-label col-sm-2" >News Title</label>
                    <div class="col-sm-10">
                        <input style="width:240px;" type="text" name="news_title" id="news_title_data" class="form-control" value="{{ request()->get('news_title') }}">
                    </div>  
                </div>
                
                <div class="form-group">
                    <label class="control-label col-sm-2" >Category</label>
                    <div class="col-sm-10">
                        <select name="news_category_id" id="news_category_data" class="form-control" style="width:240px;">
                                <option value="">---Select Category---</option>
                                @if(!empty($categories))
                                    @foreach($categories as $key=>$val)
                                        <option @if($key == request()->get('news_category_id')) selected @endif value="{{ $key }}">{{ $val }}</option>
                                    @endforeach
                                @endif
                        </select>
                    </div>
                </div>
                
                
                <div class="form-group" style="width:100%; text-align: right;">
                    <div class="col-sm-offset-2 col-sm-10">
                        <input style="display:inline-block;" type="button" id="btnHide" class="btn btn-default" Value="Hide Filter">
                        <input style="display:inline-block;" type="submit" class="btn btn-default" value="Search" />
                        <a style="display:inline-block;" class="btn btn-success" href="{{ route('news.index') }}">Clear Filter</a> 
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    $(document).ready(function(){
        @php
            if($is_search == 1) {
        @endphp
                $("#filter_area").show();
        @php
            } 
        @endphp
        $("body").on("click","#btnShow", function(){
            $("#filter_area").show();
        });
        $("body").on("click","#btnHide", function(){
            $("#filter_area").hide();
        });
    });
</script>