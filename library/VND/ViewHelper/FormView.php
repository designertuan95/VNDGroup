<?php
namespace VND\ViewHelper;
class FormView
{
	public $xHtml;
	public function __construct($arrData,$option)
	{
		if($option['type'] == 'formAdmin')
		{
			$this->xHtml = $this->formAdmin($arrData);
		}elseif($option['type'] === 'Admin'){
			$this->xHtml = $this->Admin($arrData);
		}
		
	}
	public function Admin($arrForm){

		// $arrForm = array(
		//     array(
		//         'Start_Layout' => '<div class="row">',
		//         'Widget' => array(
		//             array(
		//                 'Start_Widget'   => '<div class="widget"><div class="widget-body">',
		//                 'Content_Widget' => array(
		//                     // Box Search
		//                     array(
		//                         'Content_Box' => '<div class="form-group">
		//                                             <label class="text-no-bold"><label for="name">Tên sản phẩm</label></label>
		//                                             '.$this->formInput($_formObj->get('name')).'
		//                                         </div>',
		//                     ),
		//                 ),
		//                 'End_Widget'     => '</div></div>',
		//             ),
		//         ),
		//         'End_Layout' => '</div>'
		//     )
		// );
		$xHtml = '';
		foreach($arrForm as $layout){
		    $xHtml .= $layout['Start_Layout'];
		    foreach($layout['Widget'] as $widget ){
		        $xHtml .= $widget['Start_Widget'];
		        foreach($widget['Content_Widget'] as $BoxContent){
		            $xHtml .= $BoxContent['Content_Box'];
		        }
		        $xHtml .= $widget['End_Widget'];
		    }

		    $xHtml .= $layout['End_Layout'];
		}
		return $xHtml;
	}
	public function formAdmin($arrForm)
	{
		$xHtml = '';
		foreach($arrForm as $class => $arrColumn)
		{
			$xHtml .= sprintf('<div class="%s">',$class);
			foreach($arrColumn as $arrWidget)
			{
				$xHtml .= '<div class="widget"><div class="widget-body">';
				# Label chung cho Widget
				$xHtml .= (isset($arrWidget['LabelWidget']) && !empty($arrWidget['LabelWidget'])) ? '<label class="title-product-main text-no-bold block-display " for="exampleInputEmail2">'.$arrWidget['LabelWidget'].'</label>' : '' ;
				foreach($arrWidget['Box'] as $arrBox)
				{
					// Set display_setting
					$display_setting = (isset($arrBox['display_setting']) && !empty($arrBox['display_setting'])) ? $arrBox['display_setting'] : 'default';
					$Open_Tag = (isset($arrBox['Open_Tag']) && !empty($arrBox['Open_Tag'])) ? $arrBox['Open_Tag'] : '';
					$Close_Tag = (isset($arrBox['Close_Tag']) && !empty($arrBox['Close_Tag'])) ? $arrBox['Close_Tag'] : '';
					$LabelBox = (isset($arrBox['LabelBox']) && !empty($arrBox['LabelBox'])) ? $arrBox['LabelBox'] : '';
					$xHtml .= $LabelBox;
					$xHtml .=  $Open_Tag;
					if($display_setting == 'default')
					{
						if(!empty($arrBox['Element'])){
							foreach($arrBox['Element'] as $arrElement){

							$ClassElement = (isset($arrElement['ClassElement']) && !empty($arrElement['ClassElement'])) ? $arrElement['ClassElement'] : 'form-group';
							$xHtml .= '<div class="'.$ClassElement.'">
			                                <label class="text-no-bold">'.$arrElement['LabelElement'].'</label>
			                                '.$arrElement['Element'].'
			                            </div>';
							}
						}
						
					}else{

						foreach($arrBox['Element'] as $arrElement)
						{
							$xHtml .= $arrElement['Element'];
						}
					}
					$xHtml .= $Close_Tag;
				}
				$xHtml .= '</div></div>';
			}
			$xHtml .= '</div>';
		}
		return $xHtml;
	}
	// <!-- LAYOUT FORM -->

	// <!-- 
	// 01. Trong 1 layout form cần xác định Layout form chia làm bao nhiêu column
	// 	- Layout
	// 	1. Mỗi lây out có thể chia làm nhiều cột và có class khác nhau
	// 		+ Cột A
	// 		1.Trong một cột có nhiều widget
	// 			+ Widget
	// 			1. Mỗi widget sẽ có 1 Label chung
	// 			2. Trong 1 Widget có thể có nhiều Box hiển thị khác nhau
	// 				- Mỗi box sẽ có 1 kiểu hiển thị khác nhau
	// 				- Mỗi box sẽ có label chung
	// 				- Có thẻ mở box
	// 				- Giữa thẻ đóng và mở của box sẽ bao gồm nhiều Input và Element khác nhau
	// 				1. Mỗi Element bao gồm
	// 					+ Label
	// 					+ Input
	// 				- Thẻ đóng box
	// 		+ Cột B
	// 		Trong một cột có nhiều widget
	//  -->

		// 	$arrForm = array(
		// 	/* Cột A */
		// 	'col-lg-8 col-sm-6 col-xs-12'	=> array(
		// 		# 1 Cột có nhiều Widget => Mỗi Widget sẽ = 1 array
		// 		array(
		// 			'LabelWidget'	=> '',
		// 			# 1 Widget có nhiều box => Mỗi Box sẽ bằng 1 array
		// 			'Box'			=> array(
		// 				# Box 01
		// 				array(
		// 					# Kiểu hiển thị box
		// 					'display_setting'	=> 'default',
		// 					# Label chung dành cho box
		// 					'LabelBox'			=> '',
		// 					# Thẻ mở của Box
		// 					'Open_Tag'			=> '',
		// 					#Element OR Input box
		// 					'Element'			=> array(
		// 					# Mỗi Element sẽ là 1 array
		// 						array(
		// 							'LabelElement'	=> 'Tên thuộc tính',
		// 							'ClassElement'	=> 'form-group',
		// 							'Element'		=> '<input type="text" class="form-control" placeholder="Ví dụ : Apple , Nokia , Samsung">',
		// 						),
		// 						array(
		// 							'LabelElement'	=> 'Mô tả',
		// 							'ClassElement'	=> 'form-group',
		// 							'Element'		=> '<textarea class="form-control" rows="10"></textarea>',
		// 						),
		// 					),
		// 					# Thẻ đóng của box
		// 					'Close_Tag'			=> '',
		// 				),
		// 			)
		// 		),
				// # Widget 2
				// array(
				// 	'LabelWidget'	=> '',
				// 	# 1 Widget có nhiều box => Mỗi Box sẽ bằng 1 array
				// 	'Box'			=> array(
				// 		# Box 01
				// 		array(
				// 			# Kiểu hiển thị box
				// 			'display_setting'	=> 'default',
				// 			# Label chung dành cho box
				// 			'LabelBox'			=> '<label class="title-product-main text-no-bold block-display mb20">Chi tiết thuộc tính</label>',
				// 			# Thẻ mở của Box
				// 			'Open_Tag'			=> '<div class="pd-t-20 p-b5 border-top-title-main"><div class="clearfix">',
				// 			#Element OR Input box
				// 			'Element'			=> array(
				// 			# Mỗi Element sẽ là 1 array
				// 				array(
				// 					'LabelElement'	=> 'Thuộc tính cha',
				// 					'ClassElement'	=> 'form-group col-sm-6 p-none-l mb15',
				// 					'Element'		=> '<input type="text" class="form-control" placeholder="Ví dụ : Apple , Nokia , Samsung">',
				// 				),
				// 				array(
				// 					'LabelElement'	=> 'Trạng thái',
				// 					'ClassElement'	=> 'form-group col-sm-6 p-none-l mb15',
				// 					'Element'		=> '<input type="text" class="form-control" placeholder="Ví dụ : Apple , Nokia , Samsung">',
				// 				),
				// 			),
				// 			# Thẻ đóng của box
				// 			'Close_Tag'			=> '</div></div>',
				// 		),



				// 	)
				// ),
		// 	),
		// 	/* Cột B */
		// 	'col-lg-4 col-sm-6 col-xs-12'	=> array(
		// 		array(
		// 			'LabelWidget'	=> 'Phân loại',
		// 			# 1 Widget có nhiều box => Mỗi Box sẽ bằng 1 array
		// 			'Box'			=> array(
		// 				# Box 01
		// 				array(
		// 					# Kiểu hiển thị box
		// 					'display_setting'	=> 'default',
		// 					# Label chung dành cho box
		// 					'LabelBox'			=> '',
		// 					# Thẻ mở của Box
		// 					'Open_Tag'			=> '',
		// 					#Element OR Input box
		// 					'Element'			=> array(
		// 					# Mỗi Element sẽ là 1 array
		// 						array(
		// 							'LabelElement'	=> 'Nhóm thuộc tính',
		// 							'Element'		=> '<select id="e1" style="width:100%;">
		// 	                                <option value="AL" />Alabama
		// 	                                <option value="AK" />Alaska
		// 	                                <option value="AZ" />Arizona
		// 	                            </select>',
		// 						),
		// 					),
		// 					# Thẻ đóng của box
		// 					'Close_Tag'			=> '',
		// 				),

						
		// 			)
		// 		),
		// 		array(
		// 			'LabelWidget'	=> '',
		// 			# 1 Widget có nhiều box => Mỗi Box sẽ bằng 1 array
		// 			'Box'			=> array(
		// 				# Box 01
		// 				array(
		// 					# Kiểu hiển thị box
		// 					'display_setting'	=> 'inline-element',
		// 					# Label chung dành cho box
		// 					'LabelBox'			=> '<label class="title-product-main text-no-bold block-display text-center mb20">Hoàn thiện đăng sản phẩm</label>',
		// 					# Thẻ mở của Box
		// 					'Open_Tag'			=> '<div class="pd-t-20 border-top-title-main text-center">',
		// 					#Element OR Input box
		// 					'Element'			=> array(
		// 					# Mỗi Element sẽ là 1 array
		// 						array(
		// 						'LabelElement'	=> 'Nhóm thuộc tính',
		// 						'Element'		=> '<a class="btn btn-default" data-bind="attr: { href: ProductDetail().ProductListLink }" href="/admin/product/#/list">Lưu &amp; Thêm mới</a> ',
		// 						),
		// 						array(
		// 						'LabelElement'	=> 'Nhóm thuộc tính',
		// 						'Element'		=> '<a class="btn btn-primary" data-bind="click:Save">Lưu</a>',
		// 						),

		// 					),
		// 					# Thẻ đóng của box
		// 					'Close_Tag'			=> '</div>',
		// 				),
		// 			)
		// 		),
		// 	)
		// );
}

?>