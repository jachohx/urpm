 <div class="box-footer clearfix">
     <ul class="pagination pagination-sm no-margin pull-left">
         <li><a href="#" style="pointer-events: none;"> <?php echo '共 ' . $pager->total() . ' 条记录'; ?></a></li>
         <li><a href="#" style="pointer-events: none;"> <?php echo $pager->currentPage(); ?> / <?php echo $pager->lastPage() ?: 1; ?></a></li>
     </ul>

     <ul class="pagination pagination-sm no-margin pull-right" id="paginationBar">
         <?php
             //把url上的参数加入到分页的参数里，方便下边的previousPageUrl、url、nextPageUrl使用
             $inputs = Input::all();
             foreach ($inputs as $key => $value) {
                 $pager->appends($key, $value);
             }
         ?>
         <?php
             $pageNumList = [];
             $pageNums = [];
             $currentNum = $pager->currentPage();
             $maxNum = $pager->lastPage();
             $size = 9;
             if ($maxNum < $size) $size = $maxNum;
             //页面全部填满
             if ($size == $maxNum){
                for ($i = 1; $i <= $size; $i ++) $pageNums[] = $i;
             } else {
                 $middleIdx = floor(($size + 1) / 2);
                 if ($currentNum <= $middleIdx){
                     //左边填满，假设一共7个位置，如果中间的位置为4，那么页数只要小于4，那么前4个页数都是固定1 2 3 4
                     //左边固定，那么右边就只剩下...跟最大页
                     for ($i = 1; $i <= ($size - 2); $i++) {
                         $pageNums[] = $i;
                     }
                     $pageNums[] = "...";
                     $pageNums[] = $maxNum;
                 } else if ($currentNum >= ($maxNum - ($size - $middleIdx))) {
                     //右边填满，右边的位置是最大页数-左边占的位置。
                     //假设一共7个位置，最大页数是10，那么中间位置是4，那么右边占的位置只有3，再加上中间位置，那么只要在7 8 9 10这几页，则右边都会固定
                     //右边固定，那么左边就只剩下1 ...
                     $pageNums[] = 1;
                     $pageNums[] = "...";
                     $start = $maxNum - ($size - 2) + 1;
                     for ( $i = $start; $i <= $maxNum; $i++) {
                         $pageNums[] = $i;
                     }
                 } else {
                     //两边都没填满页数
                     //前两个，后两个位置是固定 1 ... , ... n
                     //假设一共7个位置，最大页数是10，那么中间位置是4，中间数为5，页数应该是1 ... 4 5 6 ... 10
                     //那么最左两个是1 ... ，最右两个是 ... 10，剩下 7 - 4 = 3个位置未填满页数
                     //那么就要计算其它未填的位置最开始的页数，即第3个位置
                     //第3个位置，离中间位置差了 middle-2（1 ...），所以第3个位置的页数则为 5 - (4 - 2) + 1
                     $pageNums[] = 1;
                     $pageNums[] = "...";
                     $start = $currentNum - ($middleIdx - 2) + 1;
                     for ( $i = 0; $i < ($size - 4); $i++) {
                         $pageNums[] = $start + $i;
                     }
                     $pageNums[] = "...";
                     $pageNums[] = $maxNum;
                 }
             }
             $perPages = [10, 20, 30, 40, 50, 75, 100];
         ?>
         <li class="{{ $pager->currentPage() == 1 ? 'disabled' : '' }}"><a href="{{ $pager->previousPageUrl() }}">上一页</a></li>
         @foreach($pageNums as $num)
         <li class="{{ $num == "..." ? "disabled" : ($num == $pager->currentPage() ? 'active' : '') }}"><a href="{{ $num != '...' ? $pager->url($num) : "#" }}">{{ $num }}</a></li>
         @endforeach
         <li class="{{ $pager->currentPage() == $pager->lastPage() ? 'disabled' : '' }}"><a href="{{ $pager->nextPageUrl() }}">下一页</a></li>
     </ul>
     {{--{{ $pager->render() }}--}}
     <div class="pagination pagination-sm no-margin pull-right">
         <form id="pageForm">
             @foreach(Input::all() as $key => $value)
             @if ($key != 'perPage')
             <input type="hidden" name="{{ $key }}" value="{{ $value }}">
             @endif
             @endforeach
             <select class="input-sm" name="perPage">
                 @foreach($perPages as $pageSize)
                 <option value="{{ $pageSize }}" {{ $pageSize == $pager->perPage() ? 'selected' : '' }}>{{ $pageSize }}</option>
                 @endforeach
             </select>
             &ensp;&ensp;
         </form>
     </div>
     @section('js')
     @parent
     <script>
         $(function () {
             $("#pageForm select[name=perPage]").change(function () {
                 $("#pageForm").submit();
             });
         });
     </script>
     @endsection
 </div>