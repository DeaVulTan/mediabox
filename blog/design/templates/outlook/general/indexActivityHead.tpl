<div class="clsActivityBlock clsOverflow">
  <div class="clsIndexActivities">
    <h3><span>{$LANG.common_sidebar_activities_label}</span></h3>
  </div>

  <div class="clsIndexBlogHeadingRight clsIndexBlogListMenu">
    <ul>
      <li id="selMyActivity_Head"><a href="javascript:void(0);" onClick="loadActivitySetting('My')"><span>{$LANG.common_sidebar_my_label}</span></a></li>
      <li id="selFriendsActivity_Head" ><a href="javascript:void(0);" onClick="loadActivitySetting('Friends')"><span>{$LANG.common_sidebar_friends_label}</span></a></li>
      <li id="selAllActivity_Head"><a class="clsFinalContentLink" href="javascript:void(0);" onClick="loadActivitySetting('All')"><span>{$LANG.common_sidebar_everyone_label}</span></a></li>
    </ul>
  </div>
</div>
<div class="clsCenterContentContainer clsBlogActivity">
  <div id="selMyActivity_Content"  style="display:none;"></div>
  <div id="selFriendsActivity_Content" style="display:none;"></div>
  <div id="selAllActivity_Content" style="display:none;"></div>
</div>
