<?php

/**
 * Класс буферизированного контента
 */
class ContentBuffered
{
    private $content = null;
    private $show = true;

    /**
     * Запускает буферизацию контента. 
     * Контент идущий после вызова этой функции будет буферизирован и исключён из основного потока.
     */
    public function StartContent()
    {
        ob_start();
    }

    /**
     * Останавливает буферизацию контента.
     * Контент идущий после вызова этой функции будет выводится как обычно.
     */
    public function EndContent()
    {
        $this->content = ob_get_contents();
        ob_end_clean();
    }

    /**
     * Возвращает буферизированный контент
     * @return string | null
     */
    public function GetContent()
    {
        if($this->show) return $this->content;
        return null;
    }

    /**
     * Включает отображение буферизированного контента
     */
    public function Show()
    {
        $this->show = true;
    }

    /**
     * Отключает отображение буферизированного контента
     */
    public function Hide()
    {
        $this->show = false;
    }
}

/**
 * Возвращает буферизированный контент
 * @param ContentBuffered $obj Объект буферизированного контента
 * @return string | null
 */
function GetContent(ContentBuffered $obj)
{
    return $obj->GetContent();
}

/**
 * Осуществляет отложенный вывод буферизированного контента
 * @global CMain $APPLICATION
 * @param ContentBuffered $obj Объект буферизированного контента
 */
function ShowContent(ContentBuffered $obj)
{
    global $APPLICATION;
    echo $APPLICATION->AddBufferContent("GetContent", $obj);
}