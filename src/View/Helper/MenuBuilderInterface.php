<?php

namespace CakeManager\View\Helper;

/**
 * Objects implementing this interface should declare the `implementedEvents` function
 * to notify the event manager what methods should be called when an event is triggered.
 *
 */
interface MenuBuilderInterface {

	public function beforeMenu($menu = [], $options = []);

    public function item($item = [], $options = []);

    public function beforeSubItem($item = [], $options = []);

    public function subItem($item = [], $options = []);

    public function afterSubItem($item = [], $options = []);

	public function afterMenu($menu = [], $options = []);

}
