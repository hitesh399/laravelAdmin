<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    //
    protected $guarded = ['id'];

    public function getOptionsAttribute($options)
    {
    	return json_decode($options,true);
    }

    /**
     * Converting the Field Type according to X-editable input name
     * @return string Field Type like: email, file and more
     */
    public function getFieldTypeAttribute()
    {
    	$options = $this->getOptionsAttribute($this->attributes['options']);
    	$field_type = isset($options['field_type'])?$options['field_type']:null;

    	switch ($field_type) {
    		case 'Dropdown':
    			 return 'select';
    			break;
    		case 'Timezone':
                return 'select';
    		default:
    			return str_replace('-', '_', str_slug($field_type));
    			break;
    	}
    }

    public function getDdValuesAttribute()
    {
    	$options = $this->getOptionsAttribute($this->attributes['options']);
    	$values = isset($options['values'])?$options['values']:[];
        $field_type = isset($options['field_type'])?$options['field_type']:null;
        $values = $field_type=='Timezone'?$this->getTimeZoneList():$values;
    	return is_array($values)?json_encode($values):$values;   	
    }
    
    /**
     * Getting the available timezone list
     * @return array Timezone list
     */
    private function getTimeZoneList()
    {
        $data = [];

        foreach(timezone_abbreviations_list() as $abbr => $timezone){
                foreach($timezone as $val){
                        if(isset($val['timezone_id'])){
                               
                            $data[] = $val;
                        }
                }
        }

        $data = collect($data);

        return $data->unique('timezone_id')->sortBy('timezone_id')->pluck('timezone_id','timezone_id')->toArray();
    }
}
