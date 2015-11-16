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
  
    /**
     * @inheritdoc
     * add '*' scenario name.
     */
    public function isTransactional($operation)
    {
        $scenario = $this->getScenario();
        $transactions = $this->transactions();

        $transaction = null;
        if ( isset($transactions[$scenario]) )
        {
          $transaction = $transactions[$scenario];
        }
        else if ( isset($transactions['*']) )
        {
          $transaction = $transactions['*'];
        }

        return $transaction && ($transaction & $operation);
    } 
}
