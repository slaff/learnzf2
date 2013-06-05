<?php
namespace User\Service\Invokable;

use Zend\Db\Adapter\ParameterContainer;
use Zend\Db\Adapter\Profiler\ProfilerAwareInterface;
use Zend\Db\Adapter\Profiler\ProfilerInterface;
use Zend\Db\Adapter\StatementContainer;

use Doctrine\DBAL\Logging\SQLLogger as DoctrineProfilerInterface;

class DoctrineProfiler implements ProfilerAwareInterface, DoctrineProfilerInterface
{
    /**
     *
     * @var ProfilerInterface
     */
    protected $profiler;

    public function setProfiler(ProfilerInterface $profiler)
    {
        $this->profiler = $profiler;
    }

    /**
     * {@inheritdoc}
     */
    public function startQuery($sql, array $params = null, array $types = null)
    {
        $target = new StatementContainer($sql, new ParameterContainer((array)$params));
        $this->profiler->profilerStart($target);
    }

    /**
     * {@inheritdoc}
     */
    public function stopQuery()
    {
        $this->profiler->profilerFinish();
    }
}
