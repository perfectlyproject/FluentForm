<?php

namespace inkvizytor\FluentForm\Components;

use inkvizytor\FluentForm\Base\Control;
use inkvizytor\FluentForm\Traits\CssContract;
use Illuminate\Support\Arr;

/**
 * Class TabStrip
 *
 * @package inkvizytor\FluentForm
 */
class TabStrip extends Control
{
    use CssContract;
    
    /** @var array */
    protected $guarded = ['mode', 'tabs', 'name', 'active'];

    /** @var string */
    protected $mode;
    
    /** @var array  */
    protected $tabs = [];

    /** @var string */
    protected $name = null;
    
    /** @var string */
    protected static $active = null;

    /** @var bool */
    protected $pills = null;

    /** @var bool */
    protected $justified = null;

    /**
     * @param bool $pills
     * @return $this
     */
    public function pills($pills = true)
    {
        $this->pills = $pills;

        return $this;
    }

    /**
     * @return bool
     */
    public function isPills()
    {
        return $this->pills;
    }

    /**
     * @param bool $justified
     * @return $this
     */
    public function justified($justified = true)
    {
        $this->justified = $justified;

        return $this;
    }

    /**
     * @return bool
     */
    public function isJustified()
    {
        return $this->justified;
    }
    
    /**
     * @return string
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * @param string $name
     * @param string $label
     * @param bool $active
     * @param bool $enabled
     * @return $this
     */
    public function add($name, $label, $active = false, $enabled = true)
    {
        if ($enabled == true)
        {
            if (empty($this->tabs) || $active == true)
            {
                self::$active = $name;
            }
            
            $this->tabs[$name] = $label;
        }
        
        return $this;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function active($name)
    {
        self::$active = $name;

        return $this;
    }

    /**
     * @return $this
     */
    public function open()
    {
        $this->mode = 'tabs:begin';

        return $this;
    }

    /**
     * @return $this
     */
    public function close()
    {
        $this->mode = 'tabs:end';
        self::$active = null;

        return $this;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function panel($name)
    {
        $this->mode = 'panel:begin';
        $this->name = $name;

        return $this;
    }

    /**
     * @return $this
     */
    public function end()
    {
        $this->mode = 'panel:end';

        return $this;
    }
    
    /**
     * @return string
     */
    public function render()
    {
        if ($this->getMode() == 'tabs:begin')
        {
            return $this->renderTabsBegin();
        }

        if ($this->getMode() == 'tabs:end')
        {
            return $this->renderTabsEnd();
        }

        if ($this->getMode() == 'panel:begin')
        {
            return $this->renderPanelBegin();
        }

        if ($this->getMode() == 'panel:end')
        {
            return $this->renderPanelEnd();
        }
        
        return '';
    }

    /**
     * @return string
     */
    private function renderTabsBegin()
    {
        $ul = $this->getAttr('tabs');
        $ul['class'] = implode(' ', $this->getCss());

        if (empty($ul['class'])) unset($ul['class']);

        $html  = '<div>'."\n";
        $html .= '    <ul'.$this->html()->attr($ul).'>'."\n";

        foreach ($this->tabs as $key => $value)
        {
            $li = $this->getAttr('tab');
            $active = self::$active == $key ? $this->getAttr('active') : '';
            Arr::set($li, 'class', trim(Arr::get($li, 'class', '').' '.$active));

            if (empty($li['class'])) unset($li['class']);

            $html .= '        <li'.$this->html()->attr($li).'>'."\n";
            $html .= '            <a href="#'.$key.'"'.$this->html()->attr($this->getAttr('link')).'>'.e($value).'</a>'."\n";
            $html .= '        </li>'."\n";
        }

        $html .= '    </ul>'."\n";
        $html .= '    <div'.$this->html()->attr($this->getAttr('panels')).'>';

        return $html;
    }

    /**
     * @return string
     */
    private function renderTabsEnd()
    {
        $html  = '    </div>'."\n";
        $html .= '</div>'."\n";

        return $html;
    }

    /**
     * @return string
     */
    private function renderPanelBegin()
    {
        $div = $this->getAttr('panel');
        $active = self::$active == $this->name ? $this->getAttr('active') : '';
        Arr::set($div, 'class', trim(Arr::get($div, 'class', '').' '.$active));

        if (empty($div['class'])) unset($div['class']);
        
        return '<div id="'.$this->name.'"'.$this->html()->attr($div).'>'."\n";
    }

    /**
     * @return string
     */
    private function renderPanelEnd()
    {
        return '</div>'."\n";
    }
} 