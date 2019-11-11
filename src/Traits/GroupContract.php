<?php namespace inkvizytor\FluentForm\Traits;

/**
 * Class GroupContract
 *
 * @package inkvizytor\FluentForm
 */
trait GroupContract
{
    /** @var string */
    protected $label;

    /** @var  bool */
    protected $sronly;

    /** @var bool */
    protected $required;

    /**
     * @param string $label
     * @param array $parameters
     * @param string|null $locale
     * @return $this
     */
    public function label($label, array $parameters = [], $locale = null)
    {
        $this->label = $this->translator()->get($label, $parameters, $locale);

        return $this;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param bool $required
     * @return $this
     */
    public function required($required)
    {
        $this->required = $required;

        return $this;
    }

    /**
     * @return bool
     */
    public function isRequired()
    {
        return $this->required;
    }

    /**
     * @param bool $sronly
     * @return $this
     */
    public function sronly($sronly)
    {
        $this->sronly = $sronly;

        return $this;
    }

    /**
     * @return bool
     */
    public function isSrOnly()
    {
        return $this->sronly;
    }
}