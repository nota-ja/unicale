<?php
class CMyController extends CController
{
	function CMyController()
	{
	}

	function RequestHandle()
	{
		$get	 = $this->Sanitize( $_GET );
		$post	 = $this->Sanitize( $_POST );
		$request = $this->Sanitize( $_REQUEST );

		if ( count( $get ) )	 $this->get 	= $get;
		if ( count( $post ) )	 $this->post	= $post;
		if ( count( $request ) ) $this->request	= $request;
		$this->ModelItemHandle( $get );
		$this->ModelItemHandle( $post );
	}

	function Sanitize( $request )
	{
		$request = is_array( $request ) ?
			array_map( array( get_class( $this ), 'Sanitize'), $request ) :
			htmlentities( $request, ENT_QUOTES, 'UTF-8');
		return $request;
	}}
?>