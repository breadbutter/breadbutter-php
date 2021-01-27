<?php
namespace BreadButter;


class EventValidationTypes {
    const Pass = 'pass';
    const Fail = 'fail';
    const NotApplicable = 'notapplicable';
    public static $eventValidationTypes = array(self::Pass, self::Fail, self::NotApplicable);
}