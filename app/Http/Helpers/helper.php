<?php

function convertToObject($val)
{
  if (is_string($val))
    return json_decode($val);
  else
    return json_decode(json_encode($val));
}

function convertToArray($val)
{
  if (is_string($val))
    return json_decode($val, true);
  else
    return json_decode(json_encode($val), true);
}
