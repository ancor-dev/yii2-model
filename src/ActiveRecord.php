<?php
namespace ancor\model;

use Yii;
use yii\db\ActiveRecord as _ActiveRecord;

/**
 * temporary file
 */
class ActiveRecord extends _ActiveRecord
{
	/**
	 * The name of the create scenario
	 */
	const SCENARIO_CREATE = 'create';
	/**
	 * The name of the create scenario
	 */
	const SCENARIO_UPDATE = 'update';
    
}
