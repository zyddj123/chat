<!-- 弹窗 -->
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="common-select" class="modal fade">
	<div class="modal-dialog" style="width:80%;">
		<div class="modal-content" >
			<div class="modal-header">
				<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
				<h4 class="modal-title">&nbsp;</h4>
			</div>
			<div class="modal-body"></div>
			<div class="modal-footer">
				<div class="row">
					<div class="col-lg-12">
						<button type="button" class="btn btn-success" data-dismiss="modal"><i class="fa fa-check"></i>选择</button>
						<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> 取消</button>
					</div>                    	   	
				</div>
			</div>
		</div>
	</div>
</div>

<!-- 小弹窗 -->
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="friend-select" class="modal fade">
	<div class="modal-dialog" style="width:50%;">
		<div class="modal-content" style="margin-top: 200px;">
			<div class="modal-header">
				<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
				<h4 class="modal-title">&nbsp;</h4>
			</div>
			<div class="modal-body"></div>
			<div class="modal-footer">
				<div class="row">
					<div class="col-lg-12">
						<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> 取消</button>
					</div>                    	   	
				</div>
			</div>
		</div>
	</div>
</div>
<script src='<?php echo APP_HTTP_ROOT.$this->GetThemes();?>/assets/js/wow.min.js'></script>
<script src='<?php echo APP_HTTP_ROOT.$this->GetThemes();?>/assets/js/jquery.accordion.js'></script>
<script src='<?php echo APP_HTTP_ROOT.$this->GetThemes();?>/assets/js/core.js'></script>
<script src='<?php echo APP_HTTP_ROOT.$this->GetThemes();?>/assets/js/bootstrap.min.js'></script>
<script src='<?php echo APP_HTTP_ROOT.$this->GetThemes();?>/assets/js/jquery.nicescroll.min.js'></script>
<?php @include('commonjs.php');?>