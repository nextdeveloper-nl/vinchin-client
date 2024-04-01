<?php

namespace NextDeveloper\Vinchin\Types;

enum MicrosoftVirtualizationType: int
{
    case SCVMM = 1;
    case HYPER_V_STANDALONE = 2;
    case HYPER_V_FAIL_OVER_CLUSTER = 3;
}

