<?php

namespace NextDeveloper\Vinchin\Types;

enum AvailableVirtualizationType: int
{

    case VMWARE = 1;
    case MICROSOFT_HYPER_V = 2;
    case CITRIX_XENSERVER = 3;
    case CLOUDVIE_VM = 7;
    case INCLOUD_SPHERE_XEN = 8;
    case HALSIGN_VGATE = 9;
    case NEOKYLIN = 10;
    case H3C_UIS = 11;
    case SANGFOR_HCI = 12;
    case FLEXCLOUD = 14;
    case OPENSTACK = 15;
    case HUAWEI_FUSIONCOMPUTE_KVM = 16;
    case HUAWEI_FUSIONCOMPUTE_XEN = 17;
    case WINHONG_CNWARE = 18;
    case RED_HAT_VIRTUALIZATION = 19;
    case D_SERVER = 20;
    case CLOUDVIEW_SVM = 21;
    case FLEX_HCS = 23;
    case INCLOUD_SPHERE_KVM = 24;
    case V_SERVER = 25;
    case ZSTACK_CLOUD = 26;
    case EASTED_V_SERVER = 27;
    case XCP_NG = 28;
    case ORACLE_LINUX_VIRTUALIZATION_MANAGER = 29;
    case XSKY_XECCP = 30;
    case INCLOUD_OPENSTACK = 31;
    case WINHONG_CNWARE_WINSTACK = 32;

}
