<?php $this->load->view("partial/header"); ?>

<?php $this->load->view("consultant/consultation_summary"); ?>

<?php $this->load->view("partial/footer"); ?>

<?php if ($this->Appconfig->get('print_after_sale'))
{
?>
<script type="text/javascript">
$(window).load(function()
{
	window.print();
});
</script>
<?php
}
?>