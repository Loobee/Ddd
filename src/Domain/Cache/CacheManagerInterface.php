<?php

namespace Loobee\Ddd\Domain\Cache;

interface CacheManagerInterface
{
    /**
     * Получить записи из кэша.
     *
     * @param string $prefix
     * @param string $id
     *
     * @return mixed Кэшированные данные или FALSE если в кэше данных нет.
     */
    public function fetch($prefix, $id);

    /**
     * Проверить лежат ли в кэше данные.
     *
     * @param string $prefix
     * @param string $id
     *
     * @return bool
     */
    public function contains($prefix, $id);

    /**
     * Положить данные в кэш.
     *
     * @param string $prefix
     * @param string $id
     * @param mixed $data
     * @param int $life_time Время актуальности кэша. При 0 - данные всегда актуальны.
     *
     * @return bool Успешность операции.
     */
    public function save($prefix, $id, $data, $life_time = 0);

    /**
     * Удалить данные кэша.
     *
     * @param string $prefix
     * @param string $id
     *
     * @return bool Успешность операции.
     */
    public function delete($prefix, $id);

    /**
     * Очистить кэш.
     *
     * @param string $prefix
     *
     * @return mixed
     */
    public function clean($prefix);
}