<?php
namespace ancor\model;

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
     * @event ModelEvent an event that is triggered after committing an insert transaction.
     * Or after record is inserted without transaction
     */
    const EVENT_AFTER_INSERT_TRANSACTION = 'afterInsertTransaction';
    /**
     * @event ModelEvent an event that is triggered after committing an update transaction.
     * Or after record is updated without transaction
     */
    const EVENT_AFTER_UPDATE_TRANSACTION = 'afterUpdateTransaction';
    /**
     * @event ModelEvent an event that is triggered after committing an delete transaction.
     * Or after record is deleted without transaction
     */
    const EVENT_AFTER_DELETE_TRANSACTION = 'afterDeleteTransaction';

    /**
     * @inheritdoc
     * add '*' scenario name.
     */
    public function isTransactional($operation)
    {
        $scenario     = $this->getScenario();
        $transactions = $this->transactions();

        $transaction = null;
        if (isset($transactions[$scenario])) {
            $transaction = $transactions[$scenario];
        } else {
            if (isset($transactions['*'])) {
                $transaction = $transactions['*'];
            }
        }

        return $transaction && ($transaction & $operation);
    }

    /**
     * @inheritdoc
     */
    public function insert($runValidation = true, $attributes = null)
    {
        $this->trigger(static::EVENT_AFTER_INSERT_TRANSACTION);

        return parent::insert($runValidation, $attributes);
    } // end insert()

    /**
     * @inheritdoc
     */
    public function update($runValidation = true, $attributeNames = null)
    {
        $this->trigger(static::EVENT_AFTER_UPDATE_TRANSACTION);

        return parent::update($runValidation, $attributeNames);
    } // end update()

    /**
     * @inheritdoc
     */
    public function delete()
    {
        $this->trigger(static::EVENT_AFTER_DELETE_TRANSACTION);

        return parent::delete();
    } // end delete()

}
