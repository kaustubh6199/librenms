<?php

// This is a list of stats. Can be mostly regenerated as bia the command below.
// ./nfs | jq -S .data.stats | sed 's/\:.*$/ => 1,/' | sed 's/^ */\ \ \ \ /'

$nfs_stat_keys = [
    'client_Delegs' => 1,
    'client_Layouts' => 1,
    'client_LocalLock' => 1,
    'client_LocalLown' => 1,
    'client_LocalOpen' => 1,
    'client_LocalOwn' => 1,
    'client_LockOwner' => 1,
    'client_Locks' => 1,
    'client_OpenOwner' => 1,
    'client_Opens' => 1,
    'client_cache_Attr_Hits' => 1,
    'client_cache_Attr_Misses' => 1,
    'client_cache_BioD_Hits' => 1,
    'client_cache_BioD_Misses' => 1,
    'client_cache_BioRL_Hits' => 1,
    'client_cache_BioRL_Misses' => 1,
    'client_cache_BioR_Hits' => 1,
    'client_cache_BioR_Misses' => 1,
    'client_cache_BioW_Hits' => 1,
    'client_cache_BioW_Misses' => 1,
    'client_cache_DirE_Hits' => 1,
    'client_cache_DirE_Misses' => 1,
    'client_cache_Lkup_Hits' => 1,
    'client_cache_Lkup_Misses' => 1,
    'client_network_packets' => 1,
    'client_network_tcp' => 1,
    'client_network_tcpconn' => 1,
    'client_network_udp' => 1,
    'client_rpc_Access' => 1,
    'client_rpc_Allocate' => 1,
    'client_rpc_BindConnSess' => 1,
    'client_rpc_Close' => 1,
    'client_rpc_Commit' => 1,
    'client_rpc_CommitDataS' => 1,
    'client_rpc_Copy' => 1,
    'client_rpc_Create' => 1,
    'client_rpc_CreateLayout' => 1,
    'client_rpc_CreateSess' => 1,
    'client_rpc_Deallocate' => 1,
    'client_rpc_DelegRet' => 1,
    'client_rpc_DestroyClId' => 1,
    'client_rpc_DestroySess' => 1,
    'client_rpc_ExchangeId' => 1,
    'client_rpc_FSinfo' => 1,
    'client_rpc_FreeStateID' => 1,
    'client_rpc_Fsstat' => 1,
    'client_rpc_GetAcl' => 1,
    'client_rpc_GetDevInfo' => 1,
    'client_rpc_GetExtattr' => 1,
    'client_rpc_Getattr' => 1,
    'client_rpc_IOAdvise' => 1,
    'client_rpc_LayoutCommit' => 1,
    'client_rpc_LayoutError' => 1,
    'client_rpc_LayoutGet' => 1,
    'client_rpc_LayoutReturn' => 1,
    'client_rpc_Link' => 1,
    'client_rpc_ListExtattr' => 1,
    'client_rpc_Lock' => 1,
    'client_rpc_LockT' => 1,
    'client_rpc_LockU' => 1,
    'client_rpc_Lookup' => 1,
    'client_rpc_LookupOpen' => 1,
    'client_rpc_Mkdir' => 1,
    'client_rpc_Mknod' => 1,
    'client_rpc_Open' => 1,
    'client_rpc_OpenCfr' => 1,
    'client_rpc_OpenDownGr' => 1,
    'client_rpc_OpenLayout' => 1,
    'client_rpc_PutRootFH' => 1,
    'client_rpc_RdirPlus' => 1,
    'client_rpc_Read' => 1,
    'client_rpc_ReadDataS' => 1,
    'client_rpc_Readdir' => 1,
    'client_rpc_Readlink' => 1,
    'client_rpc_ReclaimCompl' => 1,
    'client_rpc_RelLckOwn' => 1,
    'client_rpc_Remove' => 1,
    'client_rpc_Rename' => 1,
    'client_rpc_RmExtattr' => 1,
    'client_rpc_Rmdir' => 1,
    'client_rpc_Seek' => 1,
    'client_rpc_SeekDataS' => 1,
    'client_rpc_SetAcl' => 1,
    'client_rpc_SetClId' => 1,
    'client_rpc_SetClIdCf' => 1,
    'client_rpc_SetExtattr' => 1,
    'client_rpc_Setattr' => 1,
    'client_rpc_Symlink' => 1,
    'client_rpc_Write' => 1,
    'client_rpc_WriteDataS' => 1,
    'client_rpc_confirm' => 1,
    'client_rpc_fs_locations' => 1,
    'client_rpc_fsid_present' => 1,
    'client_rpc_get_lease_time' => 1,
    'client_rpc_getdevicelist' => 1,
    'client_rpc_info_Invalid' => 1,
    'client_rpc_info_Requests' => 1,
    'client_rpc_info_Retries' => 1,
    'client_rpc_info_TimedOut' => 1,
    'client_rpc_info_X_Replies' => 1,
    'client_rpc_info_authrefrsh' => 1,
    'client_rpc_layoutstats' => 1,
    'client_rpc_null' => 1,
    'client_rpc_pathConf' => 1,
    'client_rpc_root' => 1,
    'client_rpc_secinfo' => 1,
    'client_rpc_secinfo_no' => 1,
    'client_rpc_sequence' => 1,
    'client_rpc_server_caps' => 1,
    'client_rpc_test_stateid' => 1,
    'client_rpc_wrcache' => 1,
    'client_rpc_info_calls' => 1,
    'server_Clients' => 1,
    'server_Delegs' => 1,
    'server_FHcache_anon' => 1,
    'server_FHcache_lookup' => 1,
    'server_FHcache_ncachedir' => 1,
    'server_FHcache_ncachenondir' => 1,
    'server_FHcache_stale' => 1,
    'server_Layouts' => 1,
    'server_LockOwner' => 1,
    'server_Locks' => 1,
    'server_OpenOwner' => 1,
    'server_Opens' => 1,
    'server_RAcache_0' => 1,
    'server_RAcache_1' => 1,
    'server_RAcache_2' => 1,
    'server_RAcache_3' => 1,
    'server_RAcache_4' => 1,
    'server_RAcache_5' => 1,
    'server_RAcache_6' => 1,
    'server_RAcache_7' => 1,
    'server_RAcache_8' => 1,
    'server_RAcache_9' => 1,
    'server_RAcache_notfound' => 1,
    'server_cache_CacheSize' => 1,
    'server_cache_Inprog' => 1,
    'server_cache_Misses' => 1,
    'server_cache_NonIdem' => 1,
    'server_cache_TCPPeak' => 1,
    'server_cache_hits' => 1,
    'server_cache_nocache' => 1,
    'server_io_read' => 1,
    'server_io_write' => 1,
    'server_network_packets' => 1,
    'server_network_tcp' => 1,
    'server_network_tcpconn' => 1,
    'server_network_udp' => 1,
    'server_rpcStats_badauth' => 1,
    'server_rpcStats_badcalls' => 1,
    'server_rpcStats_badclnt' => 1,
    'server_rpcStats_badfmt' => 1,
    'server_rpcStats_calls' => 1,
    'server_rpc_Access' => 1,
    'server_rpc_Allocate' => 1,
    'server_rpc_BackChannelCt' => 1,
    'server_rpc_BindConnToSes' => 1,
    'server_rpc_Clone' => 1,
    'server_rpc_Close' => 1,
    'server_rpc_Commit' => 1,
    'server_rpc_Copy' => 1,
    'server_rpc_CopyNotify' => 1,
    'server_rpc_Create' => 1,
    'server_rpc_CreateSess' => 1,
    'server_rpc_Deallocate' => 1,
    'server_rpc_DelRet' => 1,
    'server_rpc_DelePurge' => 1,
    'server_rpc_DestroyClId' => 1,
    'server_rpc_DestroySess' => 1,
    'server_rpc_ExchangeID' => 1,
    'server_rpc_FSinfo' => 1,
    'server_rpc_FreeStateID' => 1,
    'server_rpc_Fsstat' => 1,
    'server_rpc_GetDevInfo' => 1,
    'server_rpc_GetDevList' => 1,
    'server_rpc_GetDirDeleg' => 1,
    'server_rpc_GetExtattr' => 1,
    'server_rpc_GetFH' => 1,
    'server_rpc_Getattr' => 1,
    'server_rpc_IOAdvise' => 1,
    'server_rpc_LayoutError' => 1,
    'server_rpc_LayoutGet' => 1,
    'server_rpc_LayoutReturn' => 1,
    'server_rpc_LayoutStats' => 1,
    'server_rpc_Link' => 1,
    'server_rpc_ListExtattr' => 1,
    'server_rpc_Lock' => 1,
    'server_rpc_LockT' => 1,
    'server_rpc_LockU' => 1,
    'server_rpc_Lookup' => 1,
    'server_rpc_LookupP' => 1,
    'server_rpc_Mkdir' => 1,
    'server_rpc_Mknod' => 1,
    'server_rpc_NVerify' => 1,
    'server_rpc_OffloadCncl' => 1,
    'server_rpc_OffloadStat' => 1,
    'server_rpc_Open' => 1,
    'server_rpc_OpenAttr' => 1,
    'server_rpc_OpenCfrm' => 1,
    'server_rpc_OpenDwnGr' => 1,
    'server_rpc_PutFH' => 1,
    'server_rpc_PutPubFH' => 1,
    'server_rpc_PutRootFH' => 1,
    'server_rpc_RdirPlus' => 1,
    'server_rpc_Read' => 1,
    'server_rpc_ReadPlus' => 1,
    'server_rpc_Readdir' => 1,
    'server_rpc_Readlink' => 1,
    'server_rpc_ReclaimCompl' => 1,
    'server_rpc_RelLockOwn' => 1,
    'server_rpc_Remove' => 1,
    'server_rpc_Rename' => 1,
    'server_rpc_Renew' => 1,
    'server_rpc_RestoreFH' => 1,
    'server_rpc_RmExtattr' => 1,
    'server_rpc_Rmdir' => 1,
    'server_rpc_SaveFH' => 1,
    'server_rpc_SecInfNoName' => 1,
    'server_rpc_Secinfo' => 1,
    'server_rpc_Seek' => 1,
    'server_rpc_Sequence' => 1,
    'server_rpc_SetClId' => 1,
    'server_rpc_SetClIdCf' => 1,
    'server_rpc_SetExtattr' => 1,
    'server_rpc_SetSSV' => 1,
    'server_rpc_Setattr' => 1,
    'server_rpc_Symlink' => 1,
    'server_rpc_TestStateID' => 1,
    'server_rpc_V4Create' => 1,
    'server_rpc_Verify' => 1,
    'server_rpc_WantDeleg' => 1,
    'server_rpc_Write' => 1,
    'server_rpc_WriteSame' => 1,
    'server_rpc_compound' => 1,
    'server_rpc_layoutCommit' => 1,
    'server_rpc_null' => 1,
    'server_rpc_op0_unused' => 1,
    'server_rpc_op1_unused' => 1,
    'server_rpc_op2_future' => 1,
    'server_rpc_pathConf' => 1,
    'server_rpc_root' => 1,
    'server_rpc_wrcache' => 1,
];

// list of stats that are gauges
$gauge_stats = [
    'server_cache_CacheSize' => 1,
];

// graph info
$nfs_graphs = [
    'client_cache' => [
        '' => [
            'client_cache_Attr_Hits' => 'Attr Hits',
            'client_cache_Attr_Misses' => 'Attr Misses',
            'client_cache_BioD_Hits' => 'BioD Hits',
            'client_cache_BioD_Misses' => 'BioD Misses',
            'client_cache_BioRL_Hits' => 'BioRL Hits',
            'client_cache_BioRL_Misses' => 'BioRL Misses',
            'client_cache_BioR_Hits' => 'BioR Hits',
            'client_cache_BioR_Misses' => 'BioR Misses',
            'client_cache_BioW_Hits' => 'BioW Hits',
            'client_cache_BioW_Misses' => 'BioW Misses',
            'client_cache_DirE_Hits' => 'DirE Hits',
            'client_cache_DirE_Misses' => 'DirE Misses',
            'client_cache_Lkup_Hits' => 'Lkup Hits',
            'client_cache_Lkup_Misses' => 'Lkup Misses',
        ],
        'freebsd' => [
            'client_cache_Attr_Hits' => 'Attr Hits',
            'client_cache_Attr_Misses' => 'Attr Misses',
            'client_cache_BioD_Hits' => 'BioD Hits',
            'client_cache_BioD_Misses' => 'BioD Misses',
            'client_cache_BioRL_Hits' => 'BioRL Hits',
            'client_cache_BioRL_Misses' => 'BioRL Misses',
            'client_cache_BioR_Hits' => 'BioR Hits',
            'client_cache_BioR_Misses' => 'BioR Misses',
            'client_cache_BioW_Hits' => 'BioW Hits',
            'client_cache_BioW_Misses' => 'BioW Misses',
            'client_cache_DirE_Hits' => 'DirE Hits',
            'client_cache_DirE_Misses' => 'DirE Misses',
            'client_cache_Lkup_Hits' => 'Lkup Hits',
            'client_cache_Lkup_Misses' => 'Lkup Misses',
        ],
    ],
    'client_rpc_info' => [
        '' => [
            'client_rpc_info_Invalid' => 'Invalid',
            'client_rpc_info_Requests' => 'Requests',
            'client_rpc_info_Retries' => 'Retries',
            'client_rpc_info_TimedOut' => 'Timedout',
            'client_rpc_info_X_Replies' => 'X Replies',
            'client_rpc_info_authrefrsh' => 'AuthRefresh',
            'client_rpc_info_calls' => 'Calls',
        ],
        'freebsd' => [
            'client_rpc_info_Invalid' => 'Invalid',
            'client_rpc_info_Requests' => 'Requests',
            'client_rpc_info_Retries' => 'Retries',
            'client_rpc_info_TimedOut' => 'Timedout',
            'client_rpc_info_X_Replies' => 'X Replies',
        ],
        'linux' => [
            'client_rpc_info_Invalid' => 'Invalid',
            'client_rpc_info_Requests' => 'Requests',
            'client_rpc_info_Retries' => 'Retries',
            'client_rpc_info_TimedOut' => 'Timedout',
            'client_rpc_info_X_Replies' => 'X Replies',
            'client_rpc_info_authrefrsh' => 'AuthRefresh',
            'client_rpc_info_calls' => 'Calls',
        ],
    ],
    'server_general' => [
        '' => [
            'server_Clients' => 'Clients',
            'server_Delegs' => 'Delegs',
            'server_Layouts' => 'Layouts',
            'server_LockOwner' => 'LockOwner',
            'server_Locks' => 'Locks',
            'server_OpenOwner' => 'OpenOwner',
            'server_Opens' => 'Opens',
        ],
        'freebsd' => [
            'server_Clients' => 'Clients',
            'server_Delegs' => 'Delegs',
            'server_Layouts' => 'Layouts',
            'server_LockOwner' => 'LockOwner',
            'server_Locks' => 'Locks',
            'server_OpenOwner' => 'OpenOwner',
            'server_Opens' => 'Opens',
        ],
    ],
    'server_rpc_info' => [
        '' => [
        ],
        'linux' => [
            'server_rpcStats_badauth' => 'Bad Auth',
            'server_rpcStats_badcalls' => 'Bad Calls',
            'server_rpcStats_badclnt' => 'Bad Client',
            'server_rpcStats_badfmt' => 'Bad Format',
            'server_rpcStats_calls' => 'Calls',
        ],
    ],
    'client_rpc' => [
        '' => [
            'client_rpc_Access' => 'Access',
            'client_rpc_Allocate' => 'Allocate',
            'client_rpc_BindConnSess' => 'BindConnSess',
            'client_rpc_Close' => 'Close',
            'client_rpc_Commit' => 'Commit',
            'client_rpc_CommitDataS' => 'CommitDataS',
            'client_rpc_Copy' => 'Copy',
            'client_rpc_Create' => 'Create',
            'client_rpc_CreateLayout' => 'CreateLayout',
            'client_rpc_CreateSess' => 'CreateSess',
            'client_rpc_Deallocate' => 'Deallocate',
            'client_rpc_DelegRet' => 'DelegRet',
            'client_rpc_DestroyClId' => 'DestroyClId',
            'client_rpc_DestroySess' => 'DestroySess',
            'client_rpc_ExchangeId' => 'ExchangeId',
            'client_rpc_FSinfo' => 'FSinfo',
            'client_rpc_FreeStateID' => 'FreeStateID',
            'client_rpc_Fsstat' => 'Fsstat',
            'client_rpc_GetAcl' => 'GetAcl',
            'client_rpc_GetDevInfo' => 'GetDevInfo',
            'client_rpc_GetExtattr' => 'GetExtattr',
            'client_rpc_Getattr' => 'Getattr',
            'client_rpc_IOAdvise' => 'IOAdvise',
            'client_rpc_LayoutCommit' => 'LayoutCommit',
            'client_rpc_LayoutError' => 'LayoutError',
            'client_rpc_LayoutGet' => 'LayoutGet',
            'client_rpc_LayoutReturn' => 'LayoutReturn',
            'client_rpc_Link' => 'Link',
            'client_rpc_ListExtattr' => 'ListExtattr',
            'client_rpc_Lock' => 'Lock',
            'client_rpc_LockT' => 'LockT',
            'client_rpc_LockU' => 'LockU',
            'client_rpc_Lookup' => 'Lookup',
            'client_rpc_LookupOpen' => 'LookupOpen',
            'client_rpc_Mkdir' => 'Mkdir',
            'client_rpc_Mknod' => 'Mknod',
            'client_rpc_Open' => 'Open',
            'client_rpc_OpenCfr' => 'OpenCfr',
            'client_rpc_OpenDownGr' => 'OpenDownGr',
            'client_rpc_OpenLayout' => 'OpenLayout',
            'client_rpc_PutRootFH' => 'PutRootFH',
            'client_rpc_RdirPlus' => 'RdirPlus',
            'client_rpc_Read' => 'Read',
            'client_rpc_ReadDataS' => 'ReadDataS',
            'client_rpc_Readdir' => 'Readdir',
            'client_rpc_Readlink' => 'Readlink',
            'client_rpc_ReclaimCompl' => 'ReclaimCompl',
            'client_rpc_RelLckOwn' => 'RelLckOwn',
            'client_rpc_Remove' => 'Remove',
            'client_rpc_Rename' => 'Rename',
            'client_rpc_RmExtattr' => 'RmExtattr',
            'client_rpc_Rmdir' => 'Rmdir',
            'client_rpc_Seek' => 'Seek',
            'client_rpc_SeekDataS' => 'SeekDataS',
            'client_rpc_SetAcl' => 'SetAcl',
            'client_rpc_SetClId' => 'SetClId',
            'client_rpc_SetClIdCf' => 'SetClIdCf',
            'client_rpc_SetExtattr' => 'SetExtattr',
            'client_rpc_Setattr' => 'Setattr',
            'client_rpc_Symlink' => 'Symlink',
            'client_rpc_Write' => 'Write',
            'client_rpc_WriteDataS' => 'WriteDataS',
            'client_rpc_clone' => 'clone',
            'client_rpc_confirm' => 'confirm',
            'client_rpc_fs_locations' => 'locations',
            'client_rpc_fsid_present' => 'fsid_present',
            'client_rpc_get_lease_time' => 'get_lease_time',
            'client_rpc_getdevicelist' => 'getdevicelist',
            'client_rpc_layoutstats' => 'layoutstats',
            'client_rpc_null' => 'null',
            'client_rpc_pathConf' => 'pathConf',
            'client_rpc_renew' => 'renew',
            'client_rpc_secinfo' => 'secinfo',
            'client_rpc_secinfo_no' => 'secinfo_no',
            'client_rpc_sequence' => 'sequence',
            'client_rpc_server_caps' => 'server_caps',
            'client_rpc_test_stateid' => 'test_stateid',
        ],
        'freebsd' => [
            'client_rpc_Access' => 'Access',
            'client_rpc_Allocate' => 'Allocate',
            'client_rpc_BindConnSess' => 'BindConnSess',
            'client_rpc_Close' => 'Close',
            'client_rpc_Commit' => 'Commit',
            'client_rpc_CommitDataS' => 'CommitDataS',
            'client_rpc_Copy' => 'Copy',
            'client_rpc_Create' => 'Create',
            'client_rpc_CreateLayout' => 'CreateLayout',
            'client_rpc_CreateSess' => 'CreateSess',
            'client_rpc_Deallocate' => 'Deallocate',
            'client_rpc_DelegRet' => 'DelegRet',
            'client_rpc_DestroyClId' => 'DestroyClId',
            'client_rpc_DestroySess' => 'DestroySess',
            'client_rpc_ExchangeId' => 'ExchangeId',
            'client_rpc_FSinfo' => 'FSinfo',
            'client_rpc_FreeStateID' => 'FreeStateID',
            'client_rpc_Fsstat' => 'Fsstat',
            'client_rpc_GetAcl' => 'GetAcl',
            'client_rpc_GetDevInfo' => 'GetDevInfo',
            'client_rpc_GetExtattr' => 'GetExtattr',
            'client_rpc_Getattr' => 'Getattr',
            'client_rpc_IOAdvise' => 'IOAdvise',
            'client_rpc_LayoutCommit' => 'LayoutCommit',
            'client_rpc_LayoutError' => 'LayoutError',
            'client_rpc_LayoutGet' => 'LayoutGet',
            'client_rpc_LayoutReturn' => 'LayoutReturn',
            'client_rpc_Link' => 'Link',
            'client_rpc_ListExtattr' => 'ListExtattr',
            'client_rpc_Lock' => 'Lock',
            'client_rpc_LockT' => 'LockT',
            'client_rpc_LockU' => 'LockU',
            'client_rpc_Lookup' => 'Lookup',
            'client_rpc_LookupOpen' => 'LookupOpen',
            'client_rpc_Mkdir' => 'Mkdir',
            'client_rpc_Mknod' => 'Mknod',
            'client_rpc_Open' => 'Open',
            'client_rpc_OpenCfr' => 'OpenCfr',
            'client_rpc_OpenDownGr' => 'OpenDownGr',
            'client_rpc_OpenLayout' => 'OpenLayout',
            'client_rpc_PutRootFH' => 'PutRootFH',
            'client_rpc_RdirPlus' => 'RdirPlus',
            'client_rpc_Read' => 'Read',
            'client_rpc_ReadDataS' => 'ReadDataS',
            'client_rpc_Readdir' => 'Readdir',
            'client_rpc_Readlink' => 'Readlink',
            'client_rpc_ReclaimCompl' => 'ReclaimCompl',
            'client_rpc_RelLckOwn' => 'RelLckOwn',
            'client_rpc_Remove' => 'Remove',
            'client_rpc_Rename' => 'Rename',
            'client_rpc_RmExtattr' => 'RmExtattr',
            'client_rpc_Rmdir' => 'Rmdir',
            'client_rpc_Seek' => 'Seek',
            'client_rpc_SeekDataS' => 'SeekDataS',
            'client_rpc_SetAcl' => 'SetAcl',
            'client_rpc_SetClId' => 'SetClId',
            'client_rpc_SetClIdCf' => 'SetClIdCf',
            'client_rpc_SetExtattr' => 'SetExtattr',
            'client_rpc_Setattr' => 'Setattr',
            'client_rpc_Symlink' => 'Symlink',
            'client_rpc_Write' => 'Write',
            'client_rpc_WriteDataS' => 'WriteDataS',
        ],
    ],
    'server_rpc' => [
        '' => [
            'server_rpc_Access' => 'Access',
            'server_rpc_Allocate' => 'Allocate',
            'server_rpc_BackChannelCt' => 'BackChannelCt',
            'server_rpc_BindConnToSes' => 'BindConnToSes',
            'server_rpc_Clone' => 'Clone',
            'server_rpc_Close' => 'Close',
            'server_rpc_Commit' => 'Commit',
            'server_rpc_Copy' => 'Copy',
            'server_rpc_CopyNotify' => 'CopyNotify',
            'server_rpc_Create' => 'Create',
            'server_rpc_CreateSess' => 'CreateSess',
            'server_rpc_Deallocate' => 'Deallocate',
            'server_rpc_DelRet' => 'DelReg',
            'server_rpc_DelePurge' => 'DelePurge',
            'server_rpc_DestroyClId' => 'DestroyClId',
            'server_rpc_DestroySess' => 'DestroySess',
            'server_rpc_ExchangeID' => 'ExchangeID',
            'server_rpc_FSinfo' => 'FSinfo',
            'server_rpc_FreeStateID' => 'FreeStateID',
            'server_rpc_Fsstat' => 'Fsstat',
            'server_rpc_GetDevInfo' => 'GetDevInfo',
            'server_rpc_GetDevList' => 'GetDevList',
            'server_rpc_GetDirDeleg' => 'GetDirDeleg',
            'server_rpc_GetExtattr' => 'GetExtattr',
            'server_rpc_GetFH' => 'GetFH',
            'server_rpc_Getattr' => 'Getattr',
            'server_rpc_IOAdvise' => 'IOAdvise',
            'server_rpc_LayoutError' => 'LayoutError',
            'server_rpc_LayoutGet' => 'LayoutGet',
            'server_rpc_LayoutReturn' => 'LayoutReturn',
            'server_rpc_LayoutStats' => 'LayoutStats',
            'server_rpc_Link' => 'Link',
            'server_rpc_ListExtattr' => 'ListExtattr',
            'server_rpc_Lock' => 'Lock',
            'server_rpc_LockT' => 'LockT',
            'server_rpc_LockU' => 'LockU',
            'server_rpc_Lookup' => 'Lookup',
            'server_rpc_LookupP' => 'LookupP',
            'server_rpc_Mkdir' => 'Mkdir',
            'server_rpc_Mknod' => 'Mknod',
            'server_rpc_NVerify' => 'NVerify',
            'server_rpc_OffloadCncl' => 'OffloadCncl',
            'server_rpc_OffloadStat' => 'OffloadStat',
            'server_rpc_Open' => 'Open',
            'server_rpc_OpenAttr' => 'OpenAttr',
            'server_rpc_OpenCfrm' => 'OpenCfrm',
            'server_rpc_OpenDwnGr' => 'OpenDwnGr',
            'server_rpc_PutFH' => 'PutFH',
            'server_rpc_PutPubFH' => 'PutPubFH',
            'server_rpc_PutRootFH' => 'PutRootFH',
            'server_rpc_RdirPlus' => 'RdirPlus',
            'server_rpc_Read' => 'Read',
            'server_rpc_ReadPlus' => 'ReadPlus',
            'server_rpc_Readdir' => 'Readdir',
            'server_rpc_Readlink' => 'Readlink',
            'server_rpc_ReclaimCompl' => 'ReclaimCompl',
            'server_rpc_RelLockOwn' => 'RelLockOwn',
            'server_rpc_Remove' => 'Remove',
            'server_rpc_Rename' => 'Rename',
            'server_rpc_Renew' => 'Renew',
            'server_rpc_RestoreFH' => 'RestoreFH',
            'server_rpc_RmExtattr' => 'RmExtattr',
            'server_rpc_Rmdir' => 'Rmdir',
            'server_rpc_SaveFH' => 'SaveFH',
            'server_rpc_SecInfNoName' => 'SecInfNoName',
            'server_rpc_Secinfo' => 'Secinfo',
            'server_rpc_Seek' => 'Seek',
            'server_rpc_Sequence' => 'Sequence',
            'server_rpc_SetClId' => 'SetClId',
            'server_rpc_SetClIdCf' => 'SetClIdCf',
            'server_rpc_SetExtattr' => 'SetExtattr',
            'server_rpc_SetSSV' => 'SetSSV',
            'server_rpc_Setattr' => 'Setattr',
            'server_rpc_Symlink' => 'Symlink',
            'server_rpc_TestStateID' => 'TestStateID',
            'server_rpc_V4Create' => 'V4Create',
            'server_rpc_Verify' => 'Verify',
            'server_rpc_WantDeleg' => 'WantDeleg',
            'server_rpc_Write' => 'Write',
            'server_rpc_WriteSame' => 'WriteSame',
            'server_rpc_compound' => 'compound',
            'server_rpc_layoutCommit' => 'layoutCommit',
            'server_rpc_null' => 'null',
            'server_rpc_op0_unused' => 'op0 unused',
            'server_rpc_op1_unused' => 'op1 unused',
            'server_rpc_op2_future' => 'op2 future',
            'server_rpc_pathConf' => 'pathConf',
            'server_rpc_root' => 'root',
            'server_rpc_wrcache' => 'wrcache',
        ],
        'freebsd' => [
            'server_rpc_Access' => 'Access',
            'server_rpc_Allocate' => 'Allocate',
            'server_rpc_BackChannelCt' => 'BackChannelCt',
            'server_rpc_BindConnToSes' => 'BindConnToSes',
            'server_rpc_Clone' => 'Clone',
            'server_rpc_Close' => 'Close',
            'server_rpc_Commit' => 'Commit',
            'server_rpc_Copy' => 'Copy',
            'server_rpc_CopyNotify' => 'CopyNotify',
            'server_rpc_Create' => 'Create',
            'server_rpc_CreateSess' => 'CreateSess',
            'server_rpc_Deallocate' => 'Deallocate',
            'server_rpc_DelRet' => 'DelReg',
            'server_rpc_DelePurge' => 'DelePurge',
            'server_rpc_DestroyClId' => 'DestroyClId',
            'server_rpc_DestroySess' => 'DestroySess',
            'server_rpc_ExchangeID' => 'ExchangeID',
            'server_rpc_FSinfo' => 'FSinfo',
            'server_rpc_FreeStateID' => 'FreeStateID',
            'server_rpc_Fsstat' => 'Fsstat',
            'server_rpc_GetDevInfo' => 'GetDevInfo',
            'server_rpc_GetDevList' => 'GetDevList',
            'server_rpc_GetDirDeleg' => 'GetDirDeleg',
            'server_rpc_GetExtattr' => 'GetExtattr',
            'server_rpc_GetFH' => 'GetFH',
            'server_rpc_Getattr' => 'Getattr',
            'server_rpc_IOAdvise' => 'IOAdvise',
            'server_rpc_LayoutError' => 'LayoutError',
            'server_rpc_LayoutGet' => 'LayoutGet',
            'server_rpc_LayoutReturn' => 'LayoutReturn',
            'server_rpc_LayoutStats' => 'LayoutStats',
            'server_rpc_Link' => 'Link',
            'server_rpc_ListExtattr' => 'ListExtattr',
            'server_rpc_Lock' => 'Lock',
            'server_rpc_LockT' => 'LockT',
            'server_rpc_LockU' => 'LockU',
            'server_rpc_Lookup' => 'Lookup',
            'server_rpc_LookupP' => 'LookupP',
            'server_rpc_Mkdir' => 'Mkdir',
            'server_rpc_Mknod' => 'Mknod',
            'server_rpc_NVerify' => 'NVerify',
            'server_rpc_OffloadCncl' => 'OffloadCncl',
            'server_rpc_OffloadStat' => 'OffloadStat',
            'server_rpc_Open' => 'Open',
            'server_rpc_OpenAttr' => 'OpenAttr',
            'server_rpc_OpenCfrm' => 'OpenCfrm',
            'server_rpc_OpenDwnGr' => 'OpenDwnGr',
            'server_rpc_PutFH' => 'PutFH',
            'server_rpc_PutPubFH' => 'PutPubFH',
            'server_rpc_PutRootFH' => 'PutRootFH',
            'server_rpc_RdirPlus' => 'RdirPlus',
            'server_rpc_Read' => 'Read',
            'server_rpc_ReadPlus' => 'ReadPlus',
            'server_rpc_Readdir' => 'Readdir',
            'server_rpc_Readlink' => 'Readlink',
            'server_rpc_ReclaimCompl' => 'ReclaimCompl',
            'server_rpc_RelLockOwn' => 'RelLockOwn',
            'server_rpc_Remove' => 'Remove',
            'server_rpc_Rename' => 'Rename',
            'server_rpc_Renew' => 'Renew',
            'server_rpc_RestoreFH' => 'RestoreFH',
            'server_rpc_RmExtattr' => 'RmExtattr',
            'server_rpc_Rmdir' => 'Rmdir',
            'server_rpc_SaveFH' => 'SaveFH',
            'server_rpc_SecInfNoName' => 'SecInfNoName',
            'server_rpc_Secinfo' => 'Secinfo',
            'server_rpc_Seek' => 'Seek',
            'server_rpc_Sequence' => 'Sequence',
            'server_rpc_SetClId' => 'SetClId',
            'server_rpc_SetClIdCf' => 'SetClIdCf',
            'server_rpc_SetExtattr' => 'SetExtattr',
            'server_rpc_SetSSV' => 'SetSSV',
            'server_rpc_Setattr' => 'Setattr',
            'server_rpc_Symlink' => 'Symlink',
            'server_rpc_TestStateID' => 'TestStateID',
            'server_rpc_V4Create' => 'V4Create',
            'server_rpc_Verify' => 'Verify',
            'server_rpc_WantDeleg' => 'WantDeleg',
            'server_rpc_Write' => 'Write',
            'server_rpc_WriteSame' => 'WriteSame',
        ],
        'linux' => [
            'server_rpc_Access' => 'Access',
            'server_rpc_Allocate' => 'Allocate',
            'server_rpc_BackChannelCt' => 'BackChannelCt',
            'server_rpc_BindConnToSes' => 'BindConnToSes',
            'server_rpc_Clone' => 'Clone',
            'server_rpc_Close' => 'Close',
            'server_rpc_Commit' => 'Commit',
            'server_rpc_Copy' => 'Copy',
            'server_rpc_CopyNotify' => 'CopyNotify',
            'server_rpc_Create' => 'Create',
            'server_rpc_CreateSess' => 'CreateSess',
            'server_rpc_Deallocate' => 'Deallocate',
            'server_rpc_DelRet' => 'DelReg',
            'server_rpc_DelePurge' => 'DelePurge',
            'server_rpc_DestroyClId' => 'DestroyClId',
            'server_rpc_DestroySess' => 'DestroySess',
            'server_rpc_ExchangeID' => 'ExchangeID',
            'server_rpc_FSinfo' => 'FSinfo',
            'server_rpc_FreeStateID' => 'FreeStateID',
            'server_rpc_Fsstat' => 'Fsstat',
            'server_rpc_GetDevInfo' => 'GetDevInfo',
            'server_rpc_GetDevList' => 'GetDevList',
            'server_rpc_GetDirDeleg' => 'GetDirDeleg',
            'server_rpc_GetExtattr' => 'GetExtattr',
            'server_rpc_GetFH' => 'GetFH',
            'server_rpc_Getattr' => 'Getattr',
            'server_rpc_IOAdvise' => 'IOAdvise',
            'server_rpc_LayoutError' => 'LayoutError',
            'server_rpc_LayoutGet' => 'LayoutGet',
            'server_rpc_LayoutReturn' => 'LayoutReturn',
            'server_rpc_LayoutStats' => 'LayoutStats',
            'server_rpc_Link' => 'Link',
            'server_rpc_ListExtattr' => 'ListExtattr',
            'server_rpc_Lock' => 'Lock',
            'server_rpc_LockT' => 'LockT',
            'server_rpc_LockU' => 'LockU',
            'server_rpc_Lookup' => 'Lookup',
            'server_rpc_LookupP' => 'LookupP',
            'server_rpc_Mkdir' => 'Mkdir',
            'server_rpc_Mknod' => 'Mknod',
            'server_rpc_NVerify' => 'NVerify',
            'server_rpc_OffloadCncl' => 'OffloadCncl',
            'server_rpc_OffloadStat' => 'OffloadStat',
            'server_rpc_Open' => 'Open',
            'server_rpc_OpenAttr' => 'OpenAttr',
            'server_rpc_OpenCfrm' => 'OpenCfrm',
            'server_rpc_OpenDwnGr' => 'OpenDwnGr',
            'server_rpc_PutFH' => 'PutFH',
            'server_rpc_PutPubFH' => 'PutPubFH',
            'server_rpc_PutRootFH' => 'PutRootFH',
            'server_rpc_RdirPlus' => 'RdirPlus',
            'server_rpc_Read' => 'Read',
            'server_rpc_ReadPlus' => 'ReadPlus',
            'server_rpc_Readdir' => 'Readdir',
            'server_rpc_Readlink' => 'Readlink',
            'server_rpc_ReclaimCompl' => 'ReclaimCompl',
            'server_rpc_RelLockOwn' => 'RelLockOwn',
            'server_rpc_Remove' => 'Remove',
            'server_rpc_Rename' => 'Rename',
            'server_rpc_Renew' => 'Renew',
            'server_rpc_RestoreFH' => 'RestoreFH',
            'server_rpc_RmExtattr' => 'RmExtattr',
            'server_rpc_Rmdir' => 'Rmdir',
            'server_rpc_SaveFH' => 'SaveFH',
            'server_rpc_SecInfNoName' => 'SecInfNoName',
            'server_rpc_Secinfo' => 'Secinfo',
            'server_rpc_Seek' => 'Seek',
            'server_rpc_Sequence' => 'Sequence',
            'server_rpc_SetClId' => 'SetClId',
            'server_rpc_SetClIdCf' => 'SetClIdCf',
            'server_rpc_SetExtattr' => 'SetExtattr',
            'server_rpc_SetSSV' => 'SetSSV',
            'server_rpc_Setattr' => 'Setattr',
            'server_rpc_Symlink' => 'Symlink',
            'server_rpc_TestStateID' => 'TestStateID',
            'server_rpc_V4Create' => 'V4Create',
            'server_rpc_Verify' => 'Verify',
            'server_rpc_WantDeleg' => 'WantDeleg',
            'server_rpc_Write' => 'Write',
            'server_rpc_WriteSame' => 'WriteSame',
            'server_rpc_compound' => 'compound',
            'server_rpc_layoutCommit' => 'layoutCommit',
            'server_rpc_null' => 'null',
            'server_rpc_op0_unused' => 'op0 unused',
            'server_rpc_op1_unused' => 'op1 unused',
            'server_rpc_op2_future' => 'op2 future',
            'server_rpc_pathConf' => 'pathConf',
            'server_rpc_root' => 'root',
            'server_rpc_wrcache' => 'wrcache',
        ],
    ],
    'server_cache' => [
        '' => [
            'server_cache_CacheSize' => 'CacheSize',
            'server_cache_Inprog' => 'Inprog',
            'server_cache_Misses' => 'Misses',
            'server_cache_Non-idem' => 'Non-idem',
            'server_cache_TCPPeak' => 'TCPPeak',
            'server_cache_hits' => 'Hits',
            'server_cache_Misses' => 'Misses',
            'server_cache_nocache' => 'No Cache',
        ],
        'freebsd' => [
            'server_cache_CacheSize' => 'CacheSize',
            'server_cache_Inprog' => 'Inprog',
            'server_cache_Misses' => 'Misses',
            'server_cache_Non-idem' => 'Non-idem',
            'server_cache_TCPPeak' => 'TCPPeak',
        ],
        'linux' => [
            'server_cache_hits' => 'Hits',
            'server_cache_Misses' => 'Misses',
            'server_cache_nocache' => 'No Cache',
        ],
    ],
    'server_RAcache' => [
        '' => [
            'server_RAcache_0' => '0-10',
            'server_RAcache_1' => '10-20',
            'server_RAcache_2' => '20-30',
            'server_RAcache_3' => '30-40',
            'server_RAcache_4' => '40-50',
            'server_RAcache_5' => '50-60',
            'server_RAcache_6' => '60-70',
            'server_RAcache_7' => '70-80',
            'server_RAcache_8' => '80-90',
            'server_RAcache_9' => '90-100',
            'server_RAcache_notfound' => 'notFound',
        ],
        'linux' => [
            'server_RAcache_0' => '0-10',
            'server_RAcache_1' => '10-20',
            'server_RAcache_2' => '20-30',
            'server_RAcache_3' => '30-40',
            'server_RAcache_4' => '40-50',
            'server_RAcache_5' => '50-60',
            'server_RAcache_6' => '60-70',
            'server_RAcache_7' => '70-80',
            'server_RAcache_8' => '80-90',
            'server_RAcache_9' => '90-100',
            'server_RAcache_notfound' => 'notFound',
        ],
    ],
    'client_network' => [
        '' => [
            'client_network_packets' => 'Packets',
            'client_network_tcp' => 'TCP',
            'client_network_tcpconn' => 'TCP Conn',
            'client_network_udp' => 'UDP',
        ],
        'linux' => [
            'client_network_packets' => 'Packets',
            'client_network_tcp' => 'TCP',
            'client_network_tcpconn' => 'TCP Conn',
            'client_network_udp' => 'UDP',
        ],
    ],
    'server_network' => [
        '' => [
            'server_network_packets' => 'Packets',
            'server_network_tcp' => 'TCP',
            'server_network_tcpconn' => 'TCP Conn',
            'server_network_udp' => 'UDP',
        ],
        'linux' => [
            'server_network_packets' => 'Packets',
            'server_network_tcp' => 'TCP',
            'server_network_tcpconn' => 'TCP Conn',
            'server_network_udp' => 'UDP',
        ],
    ],
    'server_io' => [
        '' => [
            'server_io_read' => 'Read',
            'server_io_write' => 'Write',
        ],
        'linux' => [
            'server_io_read' => 'Read',
            'server_io_write' => 'Write',
        ],
    ],
];

$nfs_graphs_colours = [
    'client_rpc' => 'rainbow',
    'server_rpc' => 'rainbow',
];
