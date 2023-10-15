<?php
$types = array(
'1' => 'Leasing', 
'2' => 'Complaint', 
'3' => 'Services', 
'4' => 'Pet Application', 
'5' => 'Maintenance Absentia', 
'6' => 'Automated Guest Access', 
'7' => 'Access Key Request', 
'8' => 'Vehicle Request', 
'9' => 'Housekeeper Request', 
'10' => 'Tenant Registrations', 
'11' => 'Tenant Registrations', 
'12' => 'Maintenance Request' 
);
?>
<span>
    {{$types[$notification->type]}}
</span>
