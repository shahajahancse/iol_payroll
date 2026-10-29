  <!-- load content -->
  <?php $content_bg = (isset($subview) && (strpos($subview, 'attn_regularization') !== false || strpos($subview, 'arrear_salary') !== false || strpos($subview, 'advanced_salary') !== false || strpos($subview, 'od/') !== false)) ? '#ffffff' : '#e5e6e9'; ?>
  <div class="page-content" style="background: <?= $content_bg ?> !important">
    <div class="clearfix"></div>
      <?php $this->load->view($subview); ?>
  </div>
  <!-- load content -->