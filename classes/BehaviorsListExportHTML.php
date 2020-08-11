<?php namespace Yfktn\SelfAssCovid\Classes;

use Backend\Classes\ControllerBehavior;
use October\Rain\Exception\ApplicationException;
use Response;

/**
 * Buat behavior supaya bisa melakukan export data dari list ke html
 */
class BehaviorsListExportHTML extends ControllerBehavior
{
    protected $requiredProperties = ['listExportConfig'];
    protected $actions = ['export'];
    protected $requiredConfig = [];
    protected $exportFileName = 'export.htm';

    public function __construct($controller)
    {
        parent::__construct($controller);
        // build config
        $this->config = $this->makeConfig($controller->listExportConfig, $this->requiredConfig);
        // process config
        if($exportFileName = $this->getConfig('export[fileName]')) {
            $this->exportFileName = $exportFileName;
        }
    }

    public function export()
    {
        return $this->exportUserList();
    }

    protected function exportUserList()
    {
        if(!$this->controller->isClassExtendedWith('Backend.Behaviors.ListController')) {
            throw new ApplicationException('Harusnya ada listnya!');
        }
        $useList = $this->getConfig('export[useList]');

        if (is_array($useList)) {
            $listDefinition = array_get($useList, 'definition');
        } else {
            $listDefinition = $useList;
        }

        $lists = $this->controller->makeLists();
        $widget = $lists[$listDefinition] ?? reset($lists);

        $columns = $widget->getVisibleColumns();

        return response()->stream(function() use($columns, $widget) {
            echo("<style>table, th, td { border: 1px solid black; border-collapse: collapse;} table{ width:100%; }</style>");
            // header
            echo ("<table><theader><tr>");
            foreach ($columns as $column) {
                // $headers[] = $widget->getHeaderValue($column);
                echo ("<th>{$widget->getHeaderValue($column)}</th>");
            }
            echo ("</tr></theader>");

            $getter = $this->getConfig('export[useList][raw]', false)
                ? 'getColumnValueRaw'
                : 'getColumnValue';

            $query = $widget->prepareQuery();
            $results = $query->get();

            if ($event = $widget->fireSystemEvent('backend.list.extendRecords', [&$results])) {
                $results = $event;
            }

            echo ("<tbody>");
            foreach ($results as $result) {
                // $record = [];
                echo ("<tr>");
                foreach ($columns as $column) {
                    $value = $widget->$getter($result, $column);
                    if (is_array($value)) {
                        $value = implode('|', $value);
                    }
                    // $record[] = $value;
                    echo ("<td>{$value}</td>");
                }
                echo ("<tr>");
                // $csv->insertOne($record);
            }
            echo ("</tbody></body>");
        });
    }
}