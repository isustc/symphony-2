<?php

/**
 * @package toolkit
 */

/**
 * Specialized DatabaseQuery that facilitate creation of sub queries (or inner queries).
 * This class holds a special reference id, normally generated by its parent DatabaseQuery
 * that must be used in the generated SQL.
 */
class DatabaseSubQuery extends DatabaseQuery
{
    /**
     * Identifier for the sub query
     * @var int
     */
    private $id;

    /**
     * Creates a new DatabaseSubQuery statement on with an optional projection.
     * It also requires a identifier $id on that will be used in a prefix in the resulting SQL.
     *
     * @see DatabaseQuery::select()
     * @see DatabaseQuery::selectCount()
     * @param Database $db
     *  The underlying database connection
     * @param int $id
     *  The unique identifier relative to the parent query for this sub query.
     * @param string $projection
     *  The columns names for include in the projection.
     *  Defaults to an empty projection.
     */
    public function __construct(Database $db, $id, array $values = [])
    {
        General::ensureType([
            'id' => ['var' => $id, 'type' => 'integer'],
        ]);
        parent::__construct($db, $values);
        $this->id = $id;
    }

    /**
     * @internal
     * Formats the given $parameter name to be used as SQL parameter.
     * In this context, the $id of the sub query is prepend to the actual parameter name.
     *
     * @param string $parameter
     *  The parameter name
     * @return string
     *  The formatted parameter name
     */
    protected function formatParameterName($parameter)
    {
        return "i{$this->id}_{$parameter}";
    }
}
