<?php

/*
	V4.71 24 Jan 2006  (c) 2000-2006 John Lim (jlim@natsoft.com.my). All rights reserved.
	  Released under both BSD license and Lesser GPL library license.
	  Whenever there is any discrepancy between the two licenses,
	  the BSD license will take precedence.
	  Set tabs to 4 for best viewing.

  	This class provides recordset pagination with
	First/Prev/Next/Last links.

	Feel free to modify this class for your own use as
	it is very basic. To learn how to use it, see the
	example in adodb/tests/testpaging.php.

	"Pablo Costa" <pablo@cbsp.com.br> implemented Render_PageLinks().

	Please note, this class is entirely unsupported,
	and no free support requests except for bug reports
	will be entertained by the author.

*/
class ADODB_Pager {
	public $id; 	// unique id for pager (defaults to 'adodb')
	public $get_querystring;
	public $db; 	// ADODB connection object
	public $sql; 	// sql used
	public $rs;	// recordset generated
	public $curr_page;	// current page number before Render() called, calculated in constructor
	public $rows;		// number of rows per page
    public $linksPerPage=10; // number of links per page in navigation bar
    public $showPageLinks;

	public $gridAttributes = 'width=100% border=1 bgcolor=white';

	// Localize text strings here
	public $first = '<code>|&lt;</code>';
	public $prev = '<code>&lt;&lt;</code>';
	public $next = '<code>>></code>';
	public $last = '<code>>|</code>';
	public $moreLinks = '...';
	public $startLinks = '...';
	public $gridHeader = false;
	public $htmlSpecialChars = true;
	public $page = 'Page';
	public $linkSelectedColor = 'red';
	public $cache = 0;  #secs to cache with CachePageExecute()

	//----------------------------------------------
	// constructor
	//
	// $db	adodb connection object
	// $sql	sql statement
	// $id	optional id to identify which pager,
	//		if you have multiple on 1 page.
	//		$id should be only be [a-z0-9]*
	//
	function ADODB_Pager(&$db,$sql,$id = 'adodb', $showPageLinks = false)
	{
	global $PHP_SELF;

		$curr_page = $id.'_curr_page';
		if (empty($PHP_SELF)) $PHP_SELF = $_SERVER['PHP_SELF'];

		$this->sql = $sql;
		$this->id = $id;
		$this->db = $db;
		$this->showPageLinks = $showPageLinks;

		$next_page = $id.'_next_page';

		if (isset($_GET[$next_page])) {
			$_SESSION[$curr_page] = $_GET[$next_page];
		}
		if (empty($_SESSION[$curr_page])) $_SESSION[$curr_page] = 1; ## at first page

		$this->curr_page = $_SESSION[$curr_page];

	}

	//---------------------------
	// Display link to first page
	function Render_First($anchor=true)
	{
	global $PHP_SELF;
		if ($anchor) {
	?>
		<a href="<?php echo $PHP_SELF,'?',$this->get_querystring,$this->id;?>_next_page=1"><?php echo $this->first;?></a> &nbsp;
	<?php
		} else {
			print "$this->first &nbsp; ";
		}
	}

	//--------------------------
	// Display link to next page
	function render_next($anchor=true)
	{
	global $PHP_SELF;

		if ($anchor) {
		?>
		<a href="<?php echo $PHP_SELF,'?',$this->get_querystring,$this->id,'_next_page=',$this->rs->AbsolutePage() + 1 ?>"><?php echo $this->next;?></a> &nbsp;
		<?php
		} else {
			print "$this->next &nbsp; ";
		}
	}

	//------------------
	// Link to last page
	//
	// for better performance with large recordsets, you can set
	// $this->db->pageExecuteCountRows = false, which disables
	// last page counting.
	function render_last($anchor=true)
	{
	global $PHP_SELF;

		if (!$this->db->pageExecuteCountRows) return;

		if ($anchor) {
		?>
			<a href="<?php echo $PHP_SELF,'?',$this->get_querystring, $this->id,'_next_page=',$this->rs->LastPageNo() ?>"><?php echo $this->last;?></a> &nbsp;
		<?php
		} else {
			print "$this->last &nbsp; ";
		}
	}

	//---------------------------------------------------
	// original code by "Pablo Costa" <pablo@cbsp.com.br>
        function render_pagelinks()
        {
        global $PHP_SELF;
            $pages        = $this->rs->LastPageNo();
            $linksperpage = $this->linksPerPage ? $this->linksPerPage : $pages;
            for($i=1; $i <= $pages; $i+=$linksperpage)
            {
                if($this->rs->AbsolutePage() >= $i)
                {
                    $start = $i;
                }
            }
			$numbers = '';
            $end = $start+$linksperpage-1;
			$link = $this->id . "_next_page";
            if($end > $pages) $end = $pages;


			if ($this->startLinks && $start > 1) {
				$pos = $start - 1;
				$numbers .= "<a href=$PHP_SELF?$link=$pos>$this->startLinks</a>  ";
            }

			for($i=$start; $i <= $end; $i++) {
                if ($this->rs->AbsolutePage() == $i)
                    $numbers .= "<font color=$this->linkSelectedColor><b>$i</b></font>  ";
                else
                     $numbers .= "<a href=$PHP_SELF?$link=$i>$i</a>  ";

            }
			if ($this->moreLinks && $end < $pages)
				$numbers .= "<a href=$PHP_SELF?$link=$i>$this->moreLinks</a>  ";
            print $numbers . ' &nbsp; ';
        }
	// Link to previous page
	function render_prev($anchor=true)
	{
	global $PHP_SELF;
		if ($anchor) {
	?>
		<a href="<?php echo $PHP_SELF,'?',$this->get_querystring,$this->id,'_next_page=',$this->rs->AbsolutePage() - 1 ?>"><?php echo $this->prev;?></a> &nbsp;
	<?php
		} else {
			print "$this->prev &nbsp; ";
		}
	}

	//--------------------------------------------------------
	// Simply rendering of grid. You should override this for
	// better control over the format of the grid
	//
	// We use output buffering to keep code clean and readable.
	function RenderGrid()
	{
	global $gSQLBlockRows; // used by rs2html to indicate how many rows to display
		include_once(ADODB_DIR.'/tohtml.inc.php');
		ob_start();
		$gSQLBlockRows = $this->rows;
		rs2html($this->rs,$this->gridAttributes,$this->gridHeader,$this->htmlSpecialChars);
		$s = ob_get_contents();
		ob_end_clean();
		return $s;
	}

	//-------------------------------------------------------
	// Navigation bar
	//
	// we use output buffering to keep the code easy to read.
	function RenderNav()
	{
		ob_start();
		if (!$this->rs->AtFirstPage()) {
			$this->Render_First();
			$this->Render_Prev();
		} else {
			$this->Render_First(false);
			$this->Render_Prev(false);
		}
        if ($this->showPageLinks){
            $this->Render_PageLinks();
        }
		if (!$this->rs->AtLastPage()) {
			$this->Render_Next();
			$this->Render_Last();
		} else {
			$this->Render_Next(false);
			$this->Render_Last(false);
		}
		$s = ob_get_contents();
		ob_end_clean();
		return $s;
	}
	function displayPageList()
	{
		global $PHP_SELF;
		$page_links = 'Page list: &nbsp;';

		if ($this->curr_page <= 11)
			{
				$from = 1;
				$to = $this->curr_page + 9;
				if ($to > $this->rs->LastPageNo())
					$to = $this->rs->LastPageNo();
			}
			else
				{
					$from = $this->curr_page - 10;
					$to = $this->curr_page + 9;
					if ($to > $this->rs->LastPageNo())
						$to = $this->rs->LastPageNo();
				}


		for ($i=$from;$i<=$to; $i++)
			{
				if ($i == $this->curr_page)
					$page_links .= $i." ";
					else
						$page_links .= "<a href=\"".$PHP_SELF.'?'.$this->get_querystring.$this->id.'_next_page='.$i."\">".$i."</a> ";
			}
		return $page_links;
	}
	function displayPageDropdown($header, $footer)
	{
		global $PHP_SELF;
		$page_links = 'Page list: &nbsp;';
		//$all_val = (substr_count($this->get_querystring, 'all=') > 0) ? str_replace('&','',str_replace('all=','',$this->get_querystring)) : $this->get_querystring;

		$get_arr = array();
		if (strlen($this->get_querystring) > 0)
		{
			$qury_str =  substr($this->get_querystring, 0, strrpos($this->get_querystring, '&'));
			if (strlen($qury_str) > 0)
				$get_arr = explode('&',$qury_str);
		}
?>
		<form name="PAGING" method="get" action="<?php echo $PHP_SELF,'?',$this->get_querystring; ?>">
<?php
		foreach($get_arr as $values)
		{
			list($key, $val) = explode('=',$values);
?>
			<input type="hidden" name="<?php echo $key;?>" value="<?php echo $val;?>" />
<?php
		}
?>
		<table class="clsADODBPageTbl">
		<tr>
		<td>Page Number:
		<select name="<?php echo $this->id;?>_next_page">
<?php
		for ($i=1; $i<=$this->rs->LastPageNo(); $i++)
			{
?>
			<option<?php echo ($i == $this->curr_page)? ' selected' : '';?> value="<?php echo $i;?>"><?php echo $i;?></option>
<?php
			}
?>
		</select>
		&nbsp;&nbsp;
		<input type="submit" class="clsSubmitButton" value="Show" />
		</td>
		<td class="clsPageNumber">
			<p><?php echo $footer;?></p>
			</td>
			<td class="clsPageNavigation"><p><?php echo $header;?></p>
		</td>
		</tr>
		</table>
		</form>
<?php
	}
	//-------------------
	// This is the footer
	function RenderPageCount()
	{
		if (!$this->db->pageExecuteCountRows) return '';
		$lastPage = $this->rs->LastPageNo();
		if ($lastPage == -1) $lastPage = 1; // check for empty rs.
		if ($this->curr_page > $lastPage) $this->curr_page = 1;
		if ($lastPage <= 1)
			return '';
		return "<font size=-1>$this->page ".$this->curr_page."/".$lastPage."</font>";
	}

	//-----------------------------------
	// Call this class to draw everything.
	function Render($rows=10, $get_querystring)
	{
		$this->get_querystring = $get_querystring;
	global $ADODB_COUNTRECS;

		$this->rows = $rows;

		if ($this->db->dataProvider == 'informix') $this->db->cursorType = IFX_SCROLL;

		$savec = $ADODB_COUNTRECS;
		if ($this->db->pageExecuteCountRows) $ADODB_COUNTRECS = true;
		if ($this->cache)
			$rs = &$this->db->CachePageExecute($this->cache,$this->sql,$rows,$this->curr_page);
		else
			$rs = &$this->db->PageExecute($this->sql,$rows,$this->curr_page);
		$ADODB_COUNTRECS = $savec;

		$this->rs = &$rs;
		if (!$rs) {
			print "<h3>Query failed: $this->sql</h3>";
			return;
		}

		if (!$rs->EOF && (!$rs->AtFirstPage() || !$rs->AtLastPage()))
			$header = $this->RenderNav();
		else
			$header = "";

		$grid = $this->RenderGrid();
		$footer = $this->RenderPageCount();

		$this->RenderLayout($header,$grid,$footer);

		$rs->Close();
		$this->rs = false;
	}

	//------------------------------------------------------
	// override this to control overall layout and formating
	/*function RenderLayout($header,$grid,$footer,$attributes='border=1 bgcolor=beige')
	{
		if($header != "" and $footer != "")
			{
				$disp_paging = "<p class=\"clsPageNumber\">".$footer."</p>"."<p class=\"clsPageNavigation\">".$header."</p>";
				echo $disp_paging,
					"<table ".$attributes." class=\"clsAdoDbPagingTbl\"><tr><td>",
						$grid,
					"</td></tr></table>",
					$disp_paging;
			}
		else
			echo "<table ".$attributes."><tr><td>",
					$grid,
				"</td></tr></table>";
	}*/
	function RenderLayout($header,$grid,$footer,$attributes='border=1 bgcolor=beige class=clsADODBOuterTbl')
	{
		if ($this->rs->LastPageNo() <= 1)
			$page_list = '';
			else
				$page_list = $this->displayPageDropdown($header, $footer);
		if($page_list != "")
			{
				$disp_paging = "<p class=\"clsPageNumber\">".$page_list."</p>";
				echo $disp_paging,
					"<table ".$attributes." class=\"clsAdoDbPagingTbl\"><tr><td>",
						$grid,
					"</td></tr></table>",
					$disp_paging;
			}
		else
			echo "<table ".$attributes." class=\"clsAdoDbPagingTbl\"><tr><td>",
					$grid,
				"</td></tr></table>";
		
		if ($this->rs->LastPageNo() > 1)
			$page_list = $this->displayPageDropdown($header, $footer);
	}
}


?>