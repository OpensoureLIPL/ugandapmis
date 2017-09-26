<style type="text/css">
	 .quick-actions li {
      box-shadow: 5px 4px 6px #888888;
    height: 100px;
    width: 254px;
    /*border-top: 0px solid #2E363F;*/
  }
    .stat-boxes li a:hover, .quick-actions li a:hover, .quick-actions-horizontal li a:hover, .stat-boxes li:hover, .quick-actions li:hover, .quick-actions-horizontal li:hover {
    /*background: #2E363F;*/
   /* border-top: 2px solid #2E363F;*/
}
p.text-center a
{
  font-size: 20px;
}
</style>
<div class="container-fluid">
  <div class="row-fluid">
    <div class="span12">
      <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
          <h5>Dashboard</h5>
        </div>
        <div class="widget-content" style="overflow: hidden;">
          <div class="quick-actions_homepage">
            <div class="row-fluid">
                <div class="span3">
                    <div class="prisoner-box modules">
                        <h5 class="text-center">
                            Male Prisoners
                        </h5>
                        <p class="text-center">
                            <a href="/uganda/prisoners">
                              <?php echo $funcall->prisonerCount(1);?>
                            </a>                                
                        </p>
                    </div>    
                </div>
                <div class="span3">
                    <div class="prisoner-box modules">
                        <h5 class="text-center">
                            <a>Female Prisoners</a>
                        </h5>
                        <p class="text-center">
                            <a href="/uganda/prisoners">
                              <?php echo $funcall->prisonerCount(2);?>
                            </a>                                
                        </p>
                    </div>
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
