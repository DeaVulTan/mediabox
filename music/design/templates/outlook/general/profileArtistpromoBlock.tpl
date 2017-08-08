 {if $CFG.admin.musics.music_artist_feature and $display_caption}
   <div class="clsArtistPromoTable">
      <table {$myobj->defaultTableBgColor}>
      	<tr>
          <th class="text clsProfileTitle" {$myobj->defaultBlockTitle} ><span class="whitetext12">{* *}</span></th>
        </tr>
        <tr>
          <td >
			<div class="clsProfileArtistPromo">{$artist_promo_caption}</div>
		 	</td>
		 </tr>
      </table>
   </div>
   {/if}