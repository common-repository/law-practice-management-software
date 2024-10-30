<?php 
	global $wpdb;
	$table_invoice = $wpdb->prefix. 'lmgt_invoice';
	$table_invoice_expenses = $wpdb->prefix. 'lmgt_invoice_expenses';
	$table_case = $wpdb->prefix. 'lmgt_cases';
	
	$result = $wpdb->get_results("SELECT DISTINCT(case_id) FROM $table_invoice");
	
	$chart_array = array();
	$chart_array[] = array(esc_html__('Case Name','lawyer_mgt'),esc_html__('Total Expense Amount','lawyer_mgt'));
	if(!empty($result))
	{
		foreach($result as $r)
		{
			$case_id=$r->case_id;
			$case_name = $wpdb->get_row("SELECT case_name FROM $table_case where id=".$case_id);
			$total_expense = $wpdb->get_row("SELECT sum($table_invoice_expenses.subtotal) as total_expense  FROM 	$table_invoice_expenses
			INNER JOIN $table_invoice
			ON $table_invoice.id=$table_invoice_expenses.invoice_id And $table_invoice.case_id=".$case_id);	
		
			$chart_array[]=array( "$case_name->case_name",round($total_expense->total_expense));
		}
	}
	$options = Array(
			'title' => esc_html__('Expenses By Case Report','lawyer_mgt'),
			'titleTextStyle' => Array('color' => '#222','fontSize' => 13,'bold'=>true,'italic'=>false,'fontName' =>'open sans'),
			'legend' =>Array('position' => 'right',
					'textStyle'=> Array('color' => '#222','fontSize' => 13,'bold'=>true,'italic'=>false,'fontName' =>'open sans')),
				
			'hAxis' => Array(
					'title' =>  esc_html__('Case Name','lawyer_mgt'),
					'titleTextStyle' => Array('color' => '#222','fontSize' => 13,'bold'=>true,'italic'=>false,'fontName' =>'open sans'),
					'textStyle' => Array('color' => '#222','fontSize' => 13),
					'maxAlternation' => 2
			),
			'vAxis' => Array(
					'title' =>  esc_html__('Expense Amount','lawyer_mgt'),
				 'minValue' => 0,
					//'maxValue' => 5000,
				 'format' => '#',
					'titleTextStyle' => Array('color' => '#222','fontSize' => 13,'bold'=>true,'italic'=>false,'fontName' =>'open sans'),
					'textStyle' => Array('color' => '#222','fontSize' => 13)
			)
	);


require_once LAWMS_PLUGIN_DIR.'/lib/chart/GoogleCharts.class.php';
$GoogleCharts = new GoogleCharts;
if(!empty($result))
{
	$chart = $GoogleCharts->load( 'column' , 'chart_div' )->get( $chart_array , $options );
}

	if(isset($result) && count($result) >0)
	{
	?>
	<div id="chart_div" class="width_100_per_height_500px"></div>
  
  <!-- Javascript --> 
  <script type="text/javascript">
			<?php echo $chart;?>
	</script>
  <?php }
 if(isset($result) && empty($result))
 {?>
	<div class="clear col-md-12"><?php esc_html_e("There is not enough data to generate report.",'lawyer_mgt');?></div>
<?php }?>