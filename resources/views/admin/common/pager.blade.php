 <div class="box-footer clearfix">
     <ul class="pagination pagination-sm no-margin pull-left">
         <li><a href="#" style="pointer-events: none;"> <?php echo '共 ' . $pager->total() . ' 条记录'; ?></a></li>
         <li><a href="#" style="pointer-events: none;"> <?php echo $pager->currentPage(); ?> / <?php echo $pager->lastPage() ?: 1; ?></a></li>
     </ul>
     <?php if ($pager->lastPage() != 1) {?>
         <ul class="pagination pagination-sm no-margin pull-right" id="paginationBar">
             <li><a href="<?php echo $pager->url(1); ?>">首页</a></li>
             <li><a href="<?php echo $pager->previousPageUrl(); ?>">上一页</a></li>
             <li><a href="<?php echo $pager->nextPageUrl(); ?>">下一页</a></li>
             <li><a href="<?php echo $pager->url($pager->lastPage()); ?>">最后一页</a></li>
         </ul>
     <?php }?>
 </div>