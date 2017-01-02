<?php

// Include the SDK using the Composer autoloader
require __DIR__ . '/vendor/autoload.php';

$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->overload();

$Instance = [getenv('AWS_INSTANCE_TO_REGENERATE')];

$ec2Client = new \Aws\Ec2\Ec2Client(
    [
        'version' => '2016-11-15',
        'region'  => 'us-east-1',
    ]
);

$instance = $ec2Client->describeInstances([
    'InstanceIds' => $Instance,
]);

$oldIp = $instance['Reservations'][0]['Instances'][0]['PublicIpAddress'];

$oldAdress = $ec2Client->describeAddresses([
    'PublicIp' => $oldIp
]);

$AllocationId = $oldAdress['Addresses'][0]['AllocationId'];

$newIp = $ec2Client->allocateAddress();
print_r($newIp);

$ass = $ec2Client->associateAddress([
    'AllocationId' => $newIp['AllocationId'],
    'InstanceId'   => $Instance[0],
]);

print_r($ass);

$release = $ec2Client->releaseAddress([
    'AllocationId' => $AllocationId,
]);

print_r($release);