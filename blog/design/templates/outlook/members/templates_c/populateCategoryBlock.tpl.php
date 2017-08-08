<?php /* Smarty version 2.6.18, created on 2011-10-18 14:49:56
         compiled from populateCategoryBlock.tpl */ ?>
<div class="clsCategoryBlock">
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','blog'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'sidebar_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="clsSideBarLinks">
<div class="clsSideBarLeft">
        <p class="clsSideBarLeftTitle">
            <?php echo $this->_tpl_vars['LANG']['common_sidebar_category_heading_label']; ?>

        </p>
        <span class=""></span>
	<div class="clsSideBarRight">
    <div class="clsSideBarContent">
    <?php if ($this->_tpl_vars['populateBlogCategory_arr']['record_count']): ?>
	<div class="clsOverflow">
    	<ul>
        	<?php $this->assign('cate_break_count', 1); ?>
            <?php $_from = $this->_tpl_vars['populateBlogCategory_arr']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['genresKey'] => $this->_tpl_vars['categoryValue']):
?>
             <li class="<?php if ($this->_tpl_vars['cid'] == $this->_tpl_vars['categoryValue']['record']['blog_category_id']): ?>clsActiveLink<?php else: ?>clsInActiveLink<?php endif; ?> <?php if ($this->_tpl_vars['categoryValue']['populateSubCategory']['record_count']): ?>clsBlogSubMenu<?php endif; ?>">
              <?php if ($this->_tpl_vars['categoryValue']['populateSubCategory']['record_count']): ?>
                  <table>
                        <tr>

                            <td>
                               <a <?php if ($this->_tpl_vars['cid'] == $this->_tpl_vars['categoryValue']['record']['blog_category_id']): ?>class='clsHideSubmenuLinks'<?php else: ?>class="clsShowSubmenuLinks"<?php endif; ?> href="javascript:void(0)" id="mainCategoryID<?php echo $this->_tpl_vars['cate_break_count']; ?>
" onClick="showHideMenu('ancCategory', 'subCategoryID', '<?php echo $this->_tpl_vars['cate_break_count']; ?>
', 'categoryCount', 'mainCategoryID')"><?php echo $this->_tpl_vars['LANG']['common_myblogpost_detail_show']; ?>
</a>
                            </td>
                            <td class="clsNoSubmenuImg">
                                <a id="ancCategory<?php echo $this->_tpl_vars['cate_break_count']; ?>
"  class="" href="<?php echo $this->_tpl_vars['categoryValue']['blogpostlist_url']; ?>
" title="<?php echo $this->_tpl_vars['categoryValue']['record']['blog_category_name']; ?>
"><?php echo $this->_tpl_vars['categoryValue']['blog_category_name']; ?>
 &nbsp;<span>(<?php echo $this->_tpl_vars['categoryValue']['postCount']; ?>
)</span></a>
                            </td>
                        </tr>
                   </table>
                <?php else: ?>
                   <a href="<?php echo $this->_tpl_vars['categoryValue']['blogpostlist_url']; ?>
" title="<?php echo $this->_tpl_vars['categoryValue']['record']['blog_category_name']; ?>
"><?php echo $this->_tpl_vars['categoryValue']['blog_category_name']; ?>
 &nbsp;<span>(<?php echo $this->_tpl_vars['categoryValue']['postCount']; ?>
)</span></a>
                <?php endif; ?>
                <ul  id="subCategoryID<?php echo $this->_tpl_vars['cate_break_count']; ?>
" style="display:<?php if ($this->_tpl_vars['cid'] == $this->_tpl_vars['categoryValue']['record']['blog_category_id']): ?>block<?php else: ?>none<?php endif; ?>;">
                	<?php $_from = $this->_tpl_vars['categoryValue']['populateSubCategory']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['subgenresKey'] => $this->_tpl_vars['subcategoryValue']):
?>
                    	<li <?php if ($this->_tpl_vars['sid'] == $this->_tpl_vars['subcategoryValue']['record']['blog_category_id']): ?>class='clsActiveLink'<?php else: ?>class='clsInActiveLink'<?php endif; ?>><a href="<?php echo $this->_tpl_vars['subcategoryValue']['blogpostlist_url']; ?>
" title="<?php echo $this->_tpl_vars['subcategoryValue']['record']['blog_category_name']; ?>
"><?php echo $this->_tpl_vars['subcategoryValue']['blog_category_name']; ?>
 &nbsp;<span>(<?php echo $this->_tpl_vars['subcategoryValue']['postCount']; ?>
)</span></a></li>
                    <?php endforeach; endif; unset($_from); ?>
                </ul>
            	<?php $this->assign('cate_break_count', $this->_tpl_vars['cate_break_count']+1); ?>
            </li>
            <?php endforeach; endif; unset($_from); ?>
	        <input type="hidden" value="<?php echo $this->_tpl_vars['cate_break_count']; ?>
" id="categoryCount"  name="categoryCount" />
    	</ul>
		</div>
        <?php if ($this->_tpl_vars['morecategory_url']): ?>
        <div class="clsOverflow"><p class="clsMoreTags"><a href="<?php echo $this->_tpl_vars['morecategory_url']; ?>
"><?php echo $this->_tpl_vars['LANG']['common_sidebar_more_label']; ?>
</a></p></div>
        <?php endif; ?>
    <?php else: ?>
      	<div class="clsNoRecordsFound"><?php echo $this->_tpl_vars['LANG']['No']; ?>
</div>
    <?php endif; ?>
</div>
</div>
</div>
</div>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','blog'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'sidebar_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>