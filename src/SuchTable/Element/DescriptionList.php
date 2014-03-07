<?php
/**
 * Created by EBelair.
 * User: manu
 * Date: 07/03/14
 * Time: 16:58
 */

namespace SuchTable\Element;


use SuchTable\Element;
use SuchTable\Exception\InvalidArgumentException;

class DescriptionList extends Element
{
    protected $type = 'descriptionList';

    public function prepare()
    {
        if ($this->isPrepared === true) {
            return $this;
        }
        parent::prepare();

        $options = $this->getOptions();

        if (!isset($options['dtGetter']) || !isset($options['ddGetter'])) {
            throw new InvalidArgumentException(
                sprintf("'dtGetter' or 'ddGetter' options are missing on '%s' element", $this->getName())
            );
        }

        $content = [];
        if ($value = $this->getValue()) {
            foreach ($value as $line) {
                if (is_array($line)) {
                    $dt = $line[$options['dtGetter']];
                    $dd = $line[$options['ddGetter']];
                } elseif (is_object($line)) {
                    $dtGetter = 'get' . ucfirst($options['dtGetter']);
                    $ddGetter = 'get' . ucfirst($options['ddGetter']);

                    if (!method_exists($line, $dtGetter) || !method_exists($line, $ddGetter)) {
                        throw new InvalidArgumentException(
                            sprintf('object has to be accessible with "%s" or "%s" methods', $dtGetter, $ddGetter)
                        );
                    }
                    $dt = $line->$dtGetter();
                    $dd = $line->$ddGetter();
                } else {
                    throw new InvalidArgumentException(
                        sprintf("Invalid type of data, expected array or object found %s", gettype($line))
                    );
                }
                if (isset($options['separator'])) {
                    $dt .= $options['separator'];
                }
                $content[] = [$dt => $dd];
            }

            $this->setValue($content);
        }
    }
}
