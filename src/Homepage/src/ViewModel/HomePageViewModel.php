<?php
declare(strict_types=1);

namespace Homepage\ViewModel;

/**
 * Class HomePageViewModel
 * @package Homepage\ViewModel
 */
final class HomePageViewModel
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var int
     */
    private $userOnlineCount;

    /**
     * @var int
     */
    private $autoTradeCount;

    /**
     * @var int
     */
    private $totalGuildCount;

    /**
     * @var bool
     */
    private $isMapServerOnline;

    /**
     * @var bool
     */
    private $isLoginServerOnline;

    /**
     * @var bool
     */
    private $isCharServerOnline;

    /**
     * HomePageViewModel constructor.
     * @param array $data
     */
    private function __construct(array $data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    /**
     * @param array $data
     * @return HomePageViewModel
     */
    public static function withArray(array $data) : self
    {
        return new self($data);
    }

    /**
     * @return string
     */
    public function getTitle() : string
    {
        return $this->title;
    }

    /**
     * @return int
     */
    public function getUserOnlineCount() : int
    {
        return $this->userOnlineCount;
    }

    /**
     * @return int
     */
    public function getAutoTradeCount() : int
    {
        return $this->autoTradeCount;
    }

    /**
     * @return int
     */
    public function getTotalGuildCount() : int
    {
        return $this->totalGuildCount;
    }

    /**
     * @return bool
     */
    public function isMapServerOnline() : bool
    {
        return $this->isMapServerOnline;
    }

    /**
     * @return bool
     */
    public function isLoginServerOnline() : bool
    {
        return $this->isLoginServerOnline;
    }

    /**
     * @return bool
     */
    public function isCharServerOnline() : bool
    {
        return $this->isCharServerOnline;
    }
}
